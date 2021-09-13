<div class="card" style="max-height: 150px; overflow:auto ">
    <ul class="list-reset">
        @foreach ($project->activities as $item)
            <li>
                {{ $item->description }} successfully "{{ optional($item->subject)->body }}"
                {{-- @switch($item->description)
                    @case('task_created')
                        Task created successfully {{ $item->subject->body }}
                    @break
                    @default
                        {{ $item->description }}
                    @break
                @endswitch --}}
                <span class="text-grey"> {{ $item->created_at->diffForHumans(null, true) }} </span>
            </li>
        @endforeach
    </ul>
</div>
