<x-layout>

    <!-- declaration for the $heading variable we used in our layout.blade file -->
    <x-slot:heading>
        Jobs Page
    </x-slot:heading>

    <div class="space-y-4">
        @foreach ($jobs as $job)
            <a href="/jobs/{{$job['id']}}" class="block px-4 py-6 border border-gray-200 rounded-lg">
                <div class="font-bold text-blue-500">
                    Job ID: {{ $job->id }} &nbsp;&nbsp;&nbsp; Employer:
                    {{ $job->employer->name }}
                </div>
                <div>
                    <b>{{ $job['title'] }}</b>: Pay {{ $job['salary'] }} per year.
                </div>

            </a>
        @endforeach
        <div>
            {{ $jobs->links(); }}
        </div>
    </div>
</x-layout>
