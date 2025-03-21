<form method="POST" class="vlx-form" action="{{ route('dashboard.node.update', $node->id) }}">
    @csrf

    <div class="vlx-form__box vlx-form__box--hor">
        <div class="vlx-input-box">
            <label class="h4">Name</label>
            <input required type="text" name="name" value="{{ $node->name }}" placeholder="The name of the node">
        </div>
        <div class="vlx-input-box">
            <label class="h4">IPv4</label>
            <input required type="text" name="ipv4" value="{{ $node->ipv4 }}" placeholder="127.0.0.1">
        </div>
    </div>

    <div class="vlx-form__box vlx-form__box--hor">
        <div class="vlx-input-box">
            <label class="h4">FQDN</label>
            <input required type="text" name="fqdn" value="{{ $node->fqdn }}" placeholder="server.domain.com">
        </div>
        <div class="vlx-input-box">
            <label class="h4">Endpoint</label>
            <input required type="text" name="endpoint" value="{{ $node->endpoint }}" placeholder="https://api.domain.com/api/">
        </div>
    </div>

    <div class="vlx-form__box">
        <div class="vlx-input-box">
            <label class="h4">API Key</label>
            <input required type="text" name="key" value="{{ vlxIsEncrypted($node->key) ? Crypt::decrypt($node->key) : $node->key }}" >
        </div>
        <div class="vlx-input-box">
            <label class="h4">Datalix id</label>
            <input type="text" name="datalix_id" value="{{ vlxIsEncrypted($node->datalix_id) ? Crypt::decrypt($node->datalix_id) : $node->datalix_id }}" >
        </div>
    </div>

    <div class="vlx-form__box">
        <button type="submit" name="update" class="btn btn--success btn--small">
            <i class="vlx-icon vlx-icon--floppy-disk vlx-icon--small"></i>
            Update
        </button>
    </div>

</form>
