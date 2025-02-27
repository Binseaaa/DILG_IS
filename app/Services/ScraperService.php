<?php

namespace App\Services;

use App\Models\LegalOpinion;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class ScraperService
{
    /**
     * Scrape the provided URL for legal opinions and download PDF files containing "LO" in the title.
     *
     * @param string $url The URL to scrape.
     * @param string|null $search Optional search term to filter results.
     * @return array An array of legal opinions (titles, links, references, dates, and downloaded PDFs).
     */
    public function scrapeLegalOpinions(string $url, $search = null)
    {
        $client = new Client([
            'timeout' => 60,
            'verify' => false
        ]); // Increase timeout
        $allOpinions = [];
        $categories = [];
        $uniqueOpinions = [];

        try {
            $currentPage = 1;

            while ($url) {
                Log::info("Scraping URL (Page {$currentPage}): {$url}");
                $currentPage++;

                $response = $client->request('GET', $url);
                $html = $response->getBody()->getContents();
                $crawler = new Crawler($html);

                $opinions = $crawler->filter('table.view_details tr')->each(function (Crawler $node) use ($client, $search) {
                    try {
                        $title = $node->filter('td a')->count() > 0 ? $node->filter('td a')->text() : null;
                        $link = $node->filter('td a')->count() > 0 ? $node->filter('td a')->attr('href') : null;
                        $category = $node->filter('td strong span')->count() > 0 ? $node->filter('td strong span')->text() : null;
                        $reference = $node->filter('td strong')->count() > 0 ? $node->filter('td strong')->text() : null;
                        $date = $node->filter('td[nowrap]')->count() > 0 ? $node->filter('td[nowrap]')->text() : null;

                        if ($reference) {
                            $reference = trim(str_replace('Reference No:', '', $reference));
                        }

                        if (!$title || !$link) {
                            Log::warning("Skipping row due to missing title or link: " . $node->html());
                            return null;
                        }

                        if (!str_starts_with($link, 'http')) {
                            $link = 'https://dilg.gov.ph' . $link;
                        }

                        if ($search && stripos($title, $search) === false && stripos($reference, $search) === false) {
                            return null;
                        }

                        // *Step 2: Scrape the download link from the legal opinion page*
                        $downloadLink = null;
                        try {
                            $response = $client->request('GET', $link);
                            $detailHtml = $response->getBody()->getContents();
                            $detailCrawler = new Crawler($detailHtml);

                            // Extract the actual PDF download link
                            $downloadNode = $detailCrawler->filter('a.btn_download');
                            if ($downloadNode->count() > 0) {
                                $downloadLink = $downloadNode->attr('href');

                                if ($downloadLink && !str_starts_with($downloadLink, 'http')) {
                                    $downloadLink = 'https://dilg.gov.ph' . $downloadLink;
                                }
                            }
                        } catch (\Exception $e) {
                            Log::warning("Failed to fetch download link for {$title}: " . $e->getMessage());
                        }

                        // Check if this legal opinion exists in the database before downloading
                        $existingOpinion = LegalOpinion::where('reference', $reference)
                        ->where('title', $title)
                        ->first();

                        $pdfPath = null;
                        if ($existingOpinion && $downloadLink) {
                        $pdfPath = $this->downloadPDF($downloadLink, $reference);
                        }

                        return compact('title', 'link', 'category', 'reference', 'date', 'downloadLink', 'pdfPath');
                    } catch (\Exception $e) {
                        Log::warning("Skipping a row due to error: " . $e->getMessage());
                        return null;
                    }
                });

                $opinions = array_filter($opinions);
                foreach ($opinions as $opinion) {
                    if (!array_key_exists($opinion['reference'], $uniqueOpinions)) {
                        $uniqueOpinions[$opinion['reference']] = $opinion;

                        // *Store the scraped data and PDF path in the database*
                        LegalOpinion::updateOrCreate(
                            ['reference' => $opinion['reference']],
                            [
                                'title' => $opinion['title'],
                                'link' => $opinion['link'],
                                'category' => $opinion['category'],
                                'date' => $opinion['date'],
                                'download_link' => $opinion['downloadLink'],
                            ]
                        );
                    }
                }

                if (empty($categories)) {
                    $categories = $crawler->filter('form.myformStyle select.catBox option')->each(function (Crawler $node) {
                        return [
                            'value' => $node->attr('value'),
                            'text' => $node->text(),
                        ];
                    });
                }

                $nextPageNode = $crawler->filter('li.pWord a:contains("next")');
                if ($nextPageNode->count() > 0) {
                    $nextPageHref = $nextPageNode->attr('href');
                    $url = str_starts_with($nextPageHref, 'http') ? $nextPageHref : 'https://dilg.gov.ph' . $nextPageHref;
                } else {
                    $url = null;
                    Log::info('No more pages to scrape.');
                }
            }

            return [
                'opinions' => array_values($uniqueOpinions),
                'categories' => $categories,
            ];
        } catch (\Exception $e) {
            Log::error('Error scraping data: ' . $e->getMessage());
            return ['error' => 'Error scraping data: ' . $e->getMessage()];
        }
    }

    /**
     * Download the PDF file if it contains "LO" in the title.
     *
     * @param string $url The PDF URL to download.
     * @param string $reference Reference number to use as filename.
     * @return string|null The local storage path of the downloaded PDF.
     */
    private function downloadPDF(string $url, string $reference)
    {
        try {
            $client = new Client(['timeout' => 60]);
            $response = $client->request('GET', $url);
    
            if ($response->getStatusCode() === 200) {
                // Use reference and title to generate the filename
                $fileName = trim($reference) . '.pdf';
                $path = "legal_opinions/{$fileName}";
    
                // Save PDF to storage
                Storage::put($path, $response->getBody()->getContents());
                Log::info("Downloaded PDF: {$path}");
    
                return $path;
            }
        } catch (\Exception $e) {
            Log::error("Failed to download PDF ({$url}): " . $e->getMessage());
        }
    
        return null;
    }     
}
