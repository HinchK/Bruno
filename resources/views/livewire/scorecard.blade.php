<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Scorecard
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="grid gap-4">
                <div class="font-bold text-xl mb-2">{{ $score->title }}</div>
                <div class="flex">
                    by&nbsp;<span class="italic">{{ $score->golfer->name  }}</span>
                    &nbsp;in&nbsp;<a href="{{ url('dashboard/categories/' . $score->category->id . '/scores') }}"
                                     class="underline">{{ $score->category->title }}</a>
                    &nbsp;on&nbsp;{{ $score->updated_at->format('F, d Y') }}
                </div>
                <div class="grid grid-flow-col">
                    @foreach ($score->images as $image)
                        <div class="px-6 py-4">
                            <img src="{{ $image->url }}" alt="{{ $image->description }}" width="300" height="200">
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-flow-col">
                    @foreach ($score->videos as $video)
                        <div class="px-6 py-4">
                            <img src="{{ $video->url }}" alt="{{ $video->title }}" width="300" height="200">
                        </div>
                    @endforeach
                </div>
                <div class="text-gray-700 text-base">
                    {!! $score->content !!}
                </div>
                <div class="flex">
                    @php
                        $tags=$score->tags->pluck('id', 'title');
                    @endphp
                    @if (count($tags) > 0)
                        Tags:
                        @foreach ($tags as $key => $tag)
                            <a href="{{ url('dashboard/tags/' . $tag . '/scores') }}"
                               class="underline px-1">{{ $key }}</a>
                        @endforeach
                    @endif
                </div>
                @if ($score->comments->count())
                    <div class="text-base">
                        <p class="text-gray-900 pt-2 pb-4">{{ $score->comments->count() }}
                            @if ($score->comments->count() > 1) Responses @else Response
                            @endif
                        </p>
                        <div class="bg-gray-100 overflow-hidden shadow-xl px-6 pt-4">
                            @foreach ($score->comments as $comment)
                                <div>
                                    <p class="text-gray-500 font-bold">
                                        {{ $comment->golfer->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $comment->created_at->format('F, d Y g:i a') }}
                                    </p>
                                    <p class="text-gray-500 pb-4">{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
{{-- https://www.php.net/manual/en/datetime.format.php --}}