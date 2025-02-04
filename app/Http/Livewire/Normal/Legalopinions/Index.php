<?php

namespace App\Http\Livewire\Normal\Legalopinions;

use App\Services\ScraperService;
use Livewire\Component;
use App\Models\LegalOpinion;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
{
    // Query distinct categories directly from the database
    $categories = LegalOpinion::distinct('category')
        ->whereNotNull('category')
        ->where('category', '!=', '')
        ->orderBy('category', 'asc')
        ->pluck('category');

    // Build the query for opinions
    $query = LegalOpinion::query();

    // Apply category filter if selected
    if ($this->selectedCategory) {
        $query->where('category', 'like', '%' . $this->selectedCategory . '%');
    }

    // Apply search filter
    if ($this->search) {
        $query->where(function ($subQuery) {
            $subQuery->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('reference', 'like', '%' . $this->search . '%')
                ->orWhere('date', 'like', '%' . $this->search . '%');
        });
    }

    // Paginate the results
    $opinions = $query->paginate(50);

    return view('livewire.normal.legalopinions.index', [
        'opinions' => $opinions,
        'categories' => $categories,
    ]);
}   

// public function sendAllLegalOpinionsToTangkaraw(){
//         // Fetch data
//         $legalOpinions = DB::connection('dilg')->table('legal_opinions')->get();

//         if ($legalOpinions->isEmpty()) {
//             Log::warning('No legal opinions found in the DILG database.');
//             session()->flash('error', 'No legal opinions to send.');
//             return;
//         }

//         Log::info('Fetched legal opinions from DILG database:', $legalOpinions->toArray());

//         // Map data
//         $legalOpinionsData = $legalOpinions->map(function ($legalOpinion) {
//             return [
//                 'title' => $legalOpinion->title,
//                 'link' => $legalOpinion->link,
//                 'category' => $legalOpinion->category,
//                 'reference' => $legalOpinion->reference,
//                 'date' => $legalOpinion->date,
//             ];
//         })->toArray();

//         Log::info('Prepared legal opinions to send:', $legalOpinionsData);

//         if (empty($legalOpinionsData)) {
//             Log::warning('Mapped legal opinions data is empty. Nothing to send.');
//             session()->flash('error', 'No legal opinions to send.');
//             return;
//         }

//         // Send to Tangkaraw
//         $response = Http::post('http://127.0.0.1:8000/webhook/legal-opinion', [
//             'legal_opinions' => $legalOpinionsData,
//         ]);

//         Log::info('Response from Tangkaraw:', [
//             'status' => $response->status(),
//             'body' => $response->body(),
//         ]);

//         if ($response->successful()) {
//             session()->flash('message', 'All legal opinions sent successfully');
//         } else {
//             session()->flash('error', 'Failed to send legal opinions to Tangkaraw');
//         }
//     }
}