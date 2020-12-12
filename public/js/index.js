function togleComment(id) {

    let bid = id.match(/\d+/g);
    console.log(bid[0]);

    let arr = { 'id': bid[0] };
    $.ajax({
        url: '/comment/togle',
        type: 'POST',
        data: JSON.stringify(arr),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function () {
            location.reload();
        },
        error: function () {
            console.log("sa");
        }
    })
};

$('input#submitButton').click(function () {

    let name = $("#cfn").val();
    let email = $("#cfe").val();
    let text = $("#cft").val();
    let comment = {
        'name': name,
        'text': text,
        'email': email
    };

    $.ajax({
        url: '/comment',
        type: 'POST',
        data: JSON.stringify(comment),
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function () {
            window.location.reload();
        }
    })
});