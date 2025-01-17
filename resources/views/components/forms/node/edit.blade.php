<form method="POST" class="form" action="{{ route('dashboard.node.update', $node->id) }}">
    @csrf

    <div class="form__box">
        <h3>Name</h3>
        <input required type="text" name="name" value="{{ $node->name }}" placeholder="The name of the node">
    </div>
    <div class="form__box">
        <div class="col">
            <h3>IPv4</h3>
            <input required type="text" name="ipv4" value="{{ $node->ipv4 }}" placeholder="127.0.0.1">
        </div>
        <div class="col">
            <h3>FQDN</h3>
            <input required type="text" name="fqdn" value="{{ $node->fqdn }}" placeholder="server.domain.com">
        </div>
    </div>
    <div class="form__box">
        <div class="col">
            <h3>Endpoint</h3>
            <input required type="text" name="endpoint" value="{{ $node->endpoint }}" placeholder="https://api.domain.com/api/">
        </div>
        <div class="col">
            <h3>API Key</h3>
            <input required type="text" name="key" value="{{ vlxIsEncrypted($node->key) ? Crypt::decrypt($node->key) : $node->key }}" >
        </div>
    </div>
    <div class="form__box">
        <button type="submit" name="add" class="btn btn--success btn--small">Update<i class="vlx-icon vlx-icon--floppy-disk vlx-icon--small"></i></button>
    </div>

</form>
