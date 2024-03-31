<div class="row upper-part">

    <div class="col-lg-4 col-md-6">
        <div class="user-tabs m-0">
            <ul class="list-group horizontal">
                <li>
                    <a href="#lists-explore" class="list-group-item list-group-item-action active" data-toggle="list"
                        role="tab"><i class="fas fa-th"></i> Lists</a>
                </li>
                <li>
                    <a href="#journals-explore" class="list-group-item list-group-item-action" data-toggle="list"
                        role="tab"><i class="fas fa-book"></i> Journals</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="tab-content ">
            <div class="tab-pane active" id="lists-explore" role="tabpanel">
                <div class="row contents">
                    @forelse ($lists as $list)

                    @include('list.block')

                    @empty
                    <div class="col-md-12 align-self-center">
                        <p class="empty"><i class="far fa-frown"></i> No users have posted.</p>
                    </div>
                    @endforelse
                    <div class="col-md-12">
                        {{ $lists->links() }}
                    </div>
                </div>
            </div>


            <div class="tab-pane" id="journals-explore" role="tabpanel">
                <div class="row journal-row contents">
                    @forelse ($journals as $journal)

                    @include('journal.block')

                    @empty
                    <div class="col-md-12 align-self-center">
                        <p class="empty"><i class="far fa-frown"></i> No users have posted.</p>
                    </div>
                    @endforelse
                    <div class="col-md-12">
                        {{ $journals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

</div>
</div>
