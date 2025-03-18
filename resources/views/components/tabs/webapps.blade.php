<div class="inner inner--webapps" data-tab-id="webapps">
    <div class="vlx-block vlx-block--webapps">
        @if (isset($node_data->webapps))
            @foreach ($node_data->webapps as $webapp)
                <div class="vlx-card vlx-card--webapp js-toggle-modal" data-target-modal="webapp-modal" data-api-target="{{ $webapp->name }}">
                    <div class="vlx-icon--wrapper">
                        <i class="vlx-icon vlx-icon--xx-large
                            @if ($webapp->type == "laravel")
                                vlx-icon--brand-laravel
                            @elseif ($webapp->type == "wordpress")
                                vlx-icon--brand-wordpress
                            @elseif ($webapp->type == "react")
                                vlx-icon--brand-react
                            @elseif ($webapp->type == "html")
                                vlx-icon--brand-html5
                            @else
                                vlx-icon--globe
                            @endif
                        "></i>
                    </div>
                    <h3 class="vlx-card__title">{{ $webapp->meta->project_name ?? $webapp->name }}</h3>

                    @if (!empty($webapp->meta->public_address))
                        <div class="vlx-meta vlx-meta--public-address">
                            <i class="vlx-icon vlx-icon--link"></i>
                            <small>{{ $webapp->meta->public_address }}</small>
                        </div>
                    @endif
                    @if (!empty($webapp->location))
                        <div class="vlx-meta vlx-meta--location">
                            <i class="vlx-icon vlx-icon--folder"></i>
                            <small>{{ $webapp->location ?? null }}</small>
                        </div>
                    @endif

                    @if (!empty($webapp->meta->public_address))
                        <a class="vlx-floating-btn" href="{{ $webapp->meta->public_address }}" target="_blank">
                            <i class="vlx-icon vlx-icon--arrow-up-right-from-square vlx-icon--medium"></i>
                        </a>
                    @endif
                </div>
            @endforeach
            <div class="vlx-card vlx-card--webapp-new js-toggle-modal" data-target-modal="webapp-modal-add">
                <div class="vlx-icon--wrapper">
                    <i class="vlx-icon vlx-icon--plus"></i>
                </div>
                <h3 class="vlx-card__title">New webapp</h3>
            </div>
        @endif
    </div>
</div>
