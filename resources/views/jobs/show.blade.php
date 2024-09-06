<x-layout>

    <!-- declaration for the $heading variable we used in our layout.blade file -->
    <x-slot:heading>
        Job
    </x-slot:heading>

    <h1 class="font-bold text-lg">{{ $job['title'] }}</h1>
    The pay for this position is  {{ $job['salary'] }} per year.

    @can('edit', $job)
    <p class="mt-6">
        <x-button href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
    </p>
    @endcan
</x-layout>
