$(function () {

    var commentId = 0;

    // Post



    $(".post-like").on("click", function (event) {
        var element = this;
        event.preventDefault();
        postId = event.target.parentNode.parentNode.dataset["post"];
        var like_amount =
            event.target.parentNode.parentNode.childNodes[6];
        var isLike = (event.target = 1);
        $.ajax({
            method: "POST",
            url: urlLike,
            dataType: "json",
            data: {
                isLike: isLike,
                postId: postId,
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

    $(".journal-like").on("click", function (event) {
        var element = this;
        event.preventDefault();
        journalId = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.dataset["journal"];
        var like_amount =
            event.target.parentNode.parentNode.childNodes[4];
        var isLike = (event.target = 1);
        $.ajax({
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

});
