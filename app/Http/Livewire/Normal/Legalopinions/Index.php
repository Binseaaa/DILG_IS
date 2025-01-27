<?php

namespace App\Http\Livewire\Normal\Legalopinions;

use App\Services\ScraperService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    protected $paginationTheme = 'bootstrap';
    protected $scraper;

    // Remove the constructor

    // Use the mount method to inject the service
    public function mount(ScraperService $scraper)
    {
        $this->scraper = $scraper;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function sendAllLegalOpinionsToTangkaraw(){
        // Fetch data
        $legalOpinions = DB::connection('dilg')->table('legal_opinions')->get();

        if ($legalOpinions->isEmpty()) {
            Log::warning('No legal opinions found in the DILG database.');
            session()->flash('error', 'No legal opinions to send.');
            return;
        }

        Log::info('Fetched legal opinions from DILG database:', $legalOpinions->toArray());

        // Map data
        $legalOpinionsData = $legalOpinions->map(function ($legalOpinion) {
            return [
                'title' => $legalOpinion->title,
                'link' => $legalOpinion->link,
                'category' => $legalOpinion->category,
                'reference' => $legalOpinion->reference,
                'date' => $legalOpinion->date,
            ];
        })->toArray();

        Log::info('Prepared legal opinions to send:', $legalOpinionsData);

        if (empty($legalOpinionsData)) {
            Log::warning('Mapped legal opinions data is empty. Nothing to send.');
            session()->flash('error', 'No legal opinions to send.');
            return;
        }

        // Send to Tangkaraw
        $response = Http::post('http://127.0.0.1:8000/webhook/legal-opinion', [
            'legal_opinions' => $legalOpinionsData,
        ]);

        Log::info('Response from Tangkaraw:', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->successful()) {
            session()->flash('message', 'All legal opinions sent successfully');
        } else {
            session()->flash('error', 'Failed to send legal opinions to Tangkaraw');
        }
    }

    
    // public function sendAllLegalOpinionsToTangkaraw(){
    // // Fetch all legal opinions from the DILG database
    //     $legalOpinions = DB::connection('dilg')->table('legal_opinions')->get();

    //     // Prepare an array of legal opinions
    //     $legalOpinionsData = $legalOpinions->map(function ($legalOpinion) {
    //         return [    
    //             'title' => $legalOpinion->title,
    //             'link' => $legalOpinion->link,
    //             'category' => $legalOpinion->category,
    //             'reference' => $legalOpinion->reference,
    //             'date' => $legalOpinion->date,
    //         ];
    //     })->toArray(); // Convert collection to array

    //     // Log the data to ensure it is correctly populated
    //     Log::info('Prepared legal opinions to send:', $legalOpinionsData);

    //     // Send the entire array of legal opinions to Tangkaraw in one request
    //     $response = Http::post('http://127.0.0.1:8000/webhook/legal-opinion', [
    //         'legal_opinions' => $legalOpinionsData,
    //     ]);

    //     Log::info('Response from Tangkaraw:', [
    //         'status' => $response->status(),
    //         'body' => $response->body(),
    //     ]);

    //     // Check if the request was successful
    //     if ($response->successful()) {
    //         session()->flash('message', 'All legal opinions sent successfully');
    //     } else {
    //         session()->flash('error', 'Failed to send legal opinions to Tangkaraw');
    //     }
    // }

    
//     public function sendAllLegalOpinionsToTangkaraw()
// {
//     // Fetch all legal opinions from the DILG database
//     $legalOpinions = DB::connection('dilg')->table('legal_opinions')->get();

//     // Prepare an array of legal opinions
//     $legalOpinionsData = $legalOpinions->map(function ($legalOpinion) {
//         return [
//             'title' => $legalOpinion->title,
//             'link' => $legalOpinion->link,
//             'category' => $legalOpinion->category,
//             'reference' => $legalOpinion->reference,
//             'date' => $legalOpinion->date,
//         ];
//     })->toArray(); // Convert collection to array

//     // Ensure the data is wrapped in 'legal_opinions'
//     $payload = [
//         'legal_opinions' => $legalOpinionsData,
//     ];

//     // Send the entire array of legal opinions to Tangkaraw in one request
//     $response = Http::post('http://127.0.0.1:8000/webhook/legal-opinion', $payload);

//     Log::info('Response from Tangkaraw:', [
//         'status' => $response->status(),
//         'body' => $response->body(),
//     ]);

//     // Check if the request was successful
//     if ($response->successful()) {
//         session()->flash('message', 'All legal opinions sent successfully');
//     } else {
//         session()->flash('error', 'Failed to send legal opinions to Tangkaraw');
//     }
// }


    public function render(Request $request)
    {
        $cacheKey = 'scraped_legal_opinions';
        $result = Cache::get($cacheKey);

        if (!$result) {
            try {
                $url = 'https://dilg.gov.ph/legal-opinions-archive/';
                $result = $this->scraper->scrapeLegalOpinions($url);
                Cache::put($cacheKey, $result, now()->addDay());
            } catch (\Exception $e) {
                return view('Scraper.error', ['error' => 'Unable to fetch legal opinions at this time.']);
            }
        }

        $opinions = collect($result['opinions'] ?? []);
        $categories = $result['categories'] ?? [];

        if ($this->search) {
            $opinions = $opinions->filter(function ($opinion) {
                return stripos($opinion['title'], $this->search) !== false ||
                    stripos($opinion['link'], $this->search) !== false ||
                    stripos($opinion['reference'], $this->search) !== false ||
                    stripos($opinion['date'], $this->search) !== false;
            });
        }

        // if ($this->selectedCategory) {
        //     $opinions = $opinions->filter(function ($opinion) {
        //         return stripos(trim($opinion['category']), trim($this->selectedCategory)) !== false;
        //     });
        // }

        $opinions = $opinions->sortByDesc(function ($opinion) {
            return strtotime($opinion['date']);
        });

        $perPage = 50;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedResults = new LengthAwarePaginator(
            $opinions->forPage($currentPage, $perPage),
            $opinions->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('livewire.normal.legalopinions.index', [
            'opinions' => $paginatedResults,
            'currentPage' => $currentPage,
            'categories' => $categories,
        ]);
    }
}
