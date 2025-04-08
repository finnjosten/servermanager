<div class="inner inner--webserver" data-tab-id="webserver">
    @if ($node->user_id == auth()->id())
        @php
            $configs = $node->get_webserver_configs();

            if (empty($configs->data)) {
                $configs->data = new stdClass();
                $configs->data->enabled = new stdClass();
                $configs->data->disabled = new stdClass();
            }
        @endphp

        <h2>Disabled configs</h2>
        <div class="vlx-block vlx-block--configs wsb--small">
            @if (count(get_object_vars($configs->data->disabled)) > 0)
                @foreach ($configs->data->disabled as $config_name => $config)

                    @php
                        $fancy_name = str_contains($config_name, ".vacso.cloud") ? str_replace(".vacso.cloud", "", $config_name) : $config_name;
                        $fancy_name = str_contains($config_name, ".conf") ? str_replace(".conf", "", $fancy_name) : $fancy_name;
                    @endphp

                    <div class="vlx-card vlx-card--config js-toggle-modal" data-target-modal="webserver-modal" data-api-target="{{ $config_name }}">
                        <h3 class="vlx-card__title">{{ $fancy_name }}</h3>

                        @if (!empty($config->root))
                            <div class="vlx-meta vlx-meta--root">
                                <i class="vlx-icon vlx-icon--folder"></i>
                                <small>{{ $config->root }}</small>
                            </div>
                        @else
                            <div class="vlx-meta vlx-meta--proxy">
                                <i class="vlx-icon vlx-icon--sitemap"></i>
                                <small>{{ $config->proxy }}</small>
                            </div>
                        @endif

                        <div class="vlx-meta vlx-meta--ssl">
                            <i class="vlx-icon vlx-icon--{{ $config->ssl->enabled ? "lock" : "lock-open" }}"></i>
                            <small>{{ $config->ssl->enabled ? "secure" : "insecure" }}</small>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="vlx-card vlx-card--config-new js-toggle-modal" data-target-modal="webserver-modal-add-disabled">
                <div class="vlx-icon--wrapper">
                    <i class="vlx-icon vlx-icon--plus"></i>
                </div>
                <h3 class="vlx-card__title">New disabled config</h3>
            </div>
        </div>

        <h2>Enabled configs</h2>
        <div class="vlx-block vlx-block--configs">

            @if (count(get_object_vars($configs->data->enabled)) > 0)
                @foreach ($configs->data->enabled as $config_name => $config)
                    @php
                        $fancy_name = str_contains($config_name, ".vacso.cloud") ? str_replace(".vacso.cloud", "", $config_name) : $config_name;
                        $fancy_name = str_contains($config_name, ".conf") ? str_replace(".conf", "", $fancy_name) : $fancy_name;
                    @endphp

                    <div class="vlx-card vlx-card--config js-toggle-modal" data-target-modal="webserver-modal" data-api-target="{{ $config_name }}">
                        <h3 class="vlx-card__title">{{ $fancy_name }}</h3>

                        @if (!empty($config->root))
                            <div class="vlx-meta vlx-meta--root">
                                <i class="vlx-icon vlx-icon--folder"></i>
                                <small>{{ $config->root }}</small>
                            </div>
                        @else
                            <div class="vlx-meta vlx-meta--proxy">
                                <i class="vlx-icon vlx-icon--sitemap"></i>
                                <small>{{ $config->proxy }}</small>
                            </div>
                        @endif

                        <div class="vlx-meta vlx-meta--ssl">
                            <i class="vlx-icon vlx-icon--{{ $config->ssl->enabled ? "lock" : "lock-open" }}"></i>
                            <small>{{ $config->ssl->enabled ? "secure" : "insecure" }}</small>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="vlx-card vlx-card--config-new js-toggle-modal" data-target-modal="webserver-modal-add">
                <div class="vlx-icon--wrapper">
                    <i class="vlx-icon vlx-icon--plus"></i>
                </div>
                <h3 class="vlx-card__title">New enabled config</h3>
            </div>

        </div>
    @else
        <h3>You cant view or edit webserver configs for this server</h3>
    @endif
</div>
