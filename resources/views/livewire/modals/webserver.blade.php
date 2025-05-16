<div class="vlx-outer-modal {{ $showModal ? '--active' : '' }} {{ $loading ? '--loading' : '' }}" id="vlx-webserver-modal">
    <div class="vlx-modal vlx-modal--webserver" wire:click.outside="hide" wire:keydown.escape.window="hide">

        <a class="vlx-close-btn js-close-modal" wire:click="hide">
            <div class="vlx-icon--wrapper">
                <i class="vlx-icon vlx-icon--xmark"></i>
            </div>
        </a>

        <form class="vlx-form">
            @csrf

            <div class="vlx-form__box vlx-form__box--hor">
                <div class="vlx-input-box">
                    <label class="h4">Root</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="root" value="{{ $root }}" placeholder="/var/www/vhost/site.vasco.cloud" readonly>
                    </div>
                </div>
                <div class="vlx-input-box">
                    <label class="h4">Proxy</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="proxy" value="{{ $proxy }}" placeholder="http://localhost:80/" readonly>
                    </div>
                </div>
            </div>
            <div class="vlx-form__box vlx-form__box--hor">
                <div class="vlx-input-box">
                    <label class="h4">Ports</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="ports" value="{{ $ports }}" placeholder="80, 443" readonly>
                    </div>
                </div>
                <div class="vlx-input-box">
                    <label class="h4">Server name</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="server_name" value="{{ $server_name }}" placeholder="site.vacso.cloud" readonly>
                    </div>
                </div>
            </div>
            <div class="vlx-form__box vlx-form__box">
                <div class="vlx-input-box">
                    <label class="h4">SSL</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="ssl" value="{{ $ssl }}" placeholder="True" readonly>
                    </div>
                </div>
            </div>
            <div class="vlx-form__box vlx-form__box--hor">
                <div class="vlx-input-box">
                    <label class="h4">Cert location</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="cert" value="{{ $cert }}" placeholder="/etc/letsencrypt/live/site.vacso.cloud/cert.pem" readonly>
                    </div>
                </div>
                <div class="vlx-input-box">
                    <label class="h4">Key location</label>
                    <div class="vlx-input">
                        <input type="text" wire:modal="key" value="{{ $key }}" placeholder="/etc/letsencrypt/live/site.vacso.cloud/key.pem" readonly>
                    </div>
                </div>
            </div>
            <div class="vlx-form__box">
                <div class="vlx-input-box">
                    <label class="h4">Content</label>
                    <div class="vlx-input">
                        <textarea class="font-code" wire:modal="content">{{ $content }}</textarea>
                    </div>
                </div>
            </div>

            <div class="btn-group btn-group--left">
                <a class="btn btn--warning btn--small {{ $btns_loading['disable'] ? " --loading" : "" }}{{ $btns_disabled['disable'] ? "--disabled" : "" }}" wire:click="disable">Disable config</a>
                <a class="btn btn--warning btn--small {{ $btns_loading['enable'] ? " --loading" : "" }}{{ $btns_disabled['enable'] ? "--disabled" : "" }}" wire:click="enable">Enable config</a>
            </div>

            <div class="btn-group btn-group--left">
                <a class="btn btn--info btn--small {{ $btns_loading['certbot'] ? " --loading" : "" }}{{ $btns_disabled['certbot'] ? "--disabled" : "" }}" wire:click="certbot">Run certbot</a>
            </div>

            <div class="btn-group btn-group--left wst--small">
                <a class="btn btn--success btn--small {{ $btns_loading['save'] ? " --loading" : "" }}{{ $btns_disabled['save'] ? "--disabled" : "" }}" wire:click="save">Save</a>
                <a class="btn btn--danger btn--small {{ $btns_loading['delete'] ? " --loading" : "" }}{{ $btns_disabled['delete'] ? "--disabled" : "" }}" wire:confirm="Are you sure you want to delete this config?">Delete</a>
            </div>

        </form>
    </div>
</div>
