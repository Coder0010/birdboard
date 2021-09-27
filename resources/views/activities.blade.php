<div class="card" style="max-height: 150px; overflow:auto ">
    <ul class="list-reset">
        @foreach ($project->activities as $item)
            <li>
                @switch($item->description)
                    @case('project_updated')
                        @if ($item->changes && count($item->changes['after']) == 1)
                            you {{ key($item->changes['after']) }} of project has been updated
                        @else
                            you project has been updated
                        @endif
                    @break
                    @case('project_created')
                        you project has been created
                    @break
                    @default
                        {{ $item->description }}
                    @break
                @endswitch
                <span class="text-grey"> {{ $item->created_at->diffForHumans(null, true) }} </span>
            </li>
        @endforeach
    </ul>
</div>
