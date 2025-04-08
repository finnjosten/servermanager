<div class="inner inner--users" data-tab-id="users">
    @if ($node->user_id == auth()->id())

    @else
        <h3>You cant view or edit users for this node</h3>
    @endif
</div>
