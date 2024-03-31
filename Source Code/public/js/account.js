$(document).ready(function () {

    var commentId = 0;

    // Post
    $(".lower-part").on("click", "article .list-like", function () {
        var element = this;
        event.preventDefault();
        listId = event.target.parentNode.parentNode.dataset["list"];
        var like_amount = event.target.parentNode.parentNode.childNodes[7];
        var isLike = (event.target = 1);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            method: "POST",
            url: urlLike,
            dataType: "json",
            data: {
                isLike: isLike,
                listId: listId,
                _token: token
            },
            success: function (data) {
                var amount = JSON.stringify(data.count);
                var likes = " Likes";
                var res = amount + likes;
                $(like_amount).text(res);
            }
        }).done(function () {
            $(element).toggleClass("is-active");
        });
    });

    // Journal

    $(".lower-part").on("click", "article .journal-like", function () {
        var element = this;
        event.preventDefault();
        journalId = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.dataset["journal"];
        var like_amount =
            event.target.parentNode.parentNode.childNodes[5];
        var isLike = (event.target = 1);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            method: "POST",
            url: urlLike,
            dataType: "json",
            data: {
                isLike: isLike,
                journalId: journalId,
                _token: token
            },
            success: function (data) {
                var amount = JSON.stringify(data.count);
                var likes = " Likes";
                var res = amount + likes;
                $(like_amount).text(res);
            }
        }).done(function () {
            $(element).toggleClass("is-active");
        });
    });

    $('button[data-action="accept"]').on('click', function (e) {
        $('#friendship').append('<input type="hidden" name="action" value="accept">');
    });

    $('button[data-action="cancel"]').on('click', function (e) {
        $('#friendship').append('<input type="hidden" name="action" value="cancel">');
    });

});
