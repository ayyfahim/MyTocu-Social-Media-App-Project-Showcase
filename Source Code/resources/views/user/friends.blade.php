<div class="row upper-part">

    <div class="col-lg-5 col-md-6">
        <div class="user-tabs m-0 mb-5">
            <ul class="list-group horizontal">
                <li>
                    <a href="#lists-friends" class="list-group-item list-group-item-action active" data-toggle="tab"
                        role="tab"><i class="fas fa-th"></i> Lists</a>
                </li>
                <li>
                    <a href="#journals-friends" class="list-group-item list-group-item-action" data-toggle="tab"
                        role="tab"><i class="fas fa-book"></i> Journals</a>
                </li>
                <li>
                    <a href="#tab-friends" class="list-group-item list-group-item-action" data-toggle="tab"
                        role="tab"><i class="fab fa-wpexplorer"></i> Friends</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-12">
        <div class="tab-content ">
            <div class="tab-pane active" id="lists-friends" role="tabpanel">
                <div class="row contents">
                    @forelse ($lists as $list)
                    @include('list.block')
                    @empty
                    <div class="col-md-12 align-self-center">
                        <p class="empty"><i class="far fa-frown"></i> Your friends haven't posted any Posts.</p>
                    </div>
                    @endforelse
                    <div class="row">
                        <div class="col-md-12">
                            {{  $lists->links() }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="tab-pane" id="journals-friends" role="tabpanel">
                <div class="row journal-row contents">
                    @forelse ($journals as $journal)
                    @include('journal.block')
                    @empty
                    <div class="col-md-12 align-self-center">
                        <p class="empty"><i class="far fa-frown"></i> Your friends haven't posted any journals.</p>
                    </div>
                    @endforelse
                    <div class="col-md-12">
                        {{  $journals->links() }}
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab-friends" role="tabpanel">
                <p data-toggle="modal" data-target="#friend_invite_modal">
                    <a href="#" onclick="preDe(event)">
                        <i class="fas fa-plus-circle"></i>
                        Invite Friend
                    </a>
                </p>
                @forelse ($friends as $friend)
                @include('user.partials.block', ['user' => $friend])
                @empty
                <div class="col-md-12 align-self-center">
                    <p class="empty"><i class="far fa-frown"></i> You currently don't have any users in your friendlist.
                    </p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
