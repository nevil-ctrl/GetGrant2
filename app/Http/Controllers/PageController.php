<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Program;
use App\Models\University;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $popularCountries = Country::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->take(6)
            ->get();

        $popularPrograms = Program::query()
            ->where('is_active', true)
            ->with('university')
            ->orderByDesc('is_top')
            ->orderBy('name')
            ->take(6)
            ->get();

        $partnerUniversities = University::query()
            ->where('is_active', true)
            ->with('country')
            ->withCount('programs')
            ->orderBy('name')
            ->take(8)
            ->get();

        return view('pages.home', compact('popularCountries', 'popularPrograms', 'partnerUniversities'));
    }

    public function countries()
    {
        $countries = Country::query()
            ->where('is_active', true)
            ->withCount('universities')
            ->orderBy('name')
            ->paginate(12);

        return view('pages.countries.index', compact('countries'));
    }

    public function country(Country $country)
    {
        $universities = $country->universities()
            ->where('is_active', true)
            ->withCount('programs')
            ->take(9)
            ->get();

        return view('pages.countries.show', compact('country', 'universities'));
    }

    public function universities(Request $request)
    {
        $countries = Country::query()->where('is_active', true)->orderBy('name')->get();

        $query = University::query()
            ->where('is_active', true)
            ->with('country')
            ->withCount('programs');

        if ($request->filled('country')) {
            $query->where('country_id', $request->integer('country'));
        }

        if ($request->filled('level')) {
            $query->where('level', $request->get('level'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->get('search').'%');
        }

        $universities = $query->orderBy('name')->paginate(12);

        return view('pages.universities.index', compact('universities', 'countries'));
    }

    public function university(University $university)
    {
        $university->load('country');

        $programs = $university->programs()
            ->where('is_active', true)
            ->orderByDesc('is_top')
            ->orderBy('name')
            ->get();

        return view('pages.universities.show', compact('university', 'programs'));
    }

    public function programs(Request $request)
    {
        $countries = Country::query()->where('is_active', true)->orderBy('name')->get();
        $universities = University::query()->where('is_active', true)->orderBy('name')->get();

        $query = Program::query()
            ->where('is_active', true)
            ->with(['university.country'])
            ->orderByDesc('is_top')
            ->orderBy('name');

        if ($request->filled('university')) {
            $query->where('university_id', $request->integer('university'));
        }

        if ($request->filled('country')) {
            $query->whereHas('university', function ($q) use ($request) {
                $q->where('country_id', $request->integer('country'));
            });
        }

        if ($request->filled('field')) {
            $query->where('field_of_study', 'like', '%'.$request->get('field').'%');
        }

        $programs = $query->paginate(12);

        return view('pages.programs.index', compact('programs', 'countries', 'universities'));
    }

    public function program(Program $program)
    {
        $program->load(['university.country']);

        return view('pages.programs.show', compact('program'));
    }

    public function onlinePrep()
    {
        return view('pages.online-prep');
    }
}
