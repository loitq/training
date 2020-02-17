$(function() 
{
    $(".view-comment").click(function(event) {
        var blogId = event.target.id;
        $.ajaxSetup({
            headers:
                {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
        });
        $.ajax({
            type: "GET",
            url:'blog/'+ blogId +'/comment',
            success: function(data) {
                $("#list-comment-"+blogId).append(generateListComment(data));
                $("#send-comment-"+blogId).append(generateSendComment(blogId));
                $("#"+blogId).hide();
            }
        });
    })
});

function generateListComment(listComments)
{
    var viewListComment = "";
    if (listComments != '') {
        listComments.forEach(element => {
            viewListComment +=
            "<div class='panel panel-info'>" +
                "<div class='panel-heading'>" +
                    "<h5>" + element.user.name + "</h5>" + 
                "</div>" +
                "<div class='panel-body'>" +
                    element.comment_content + 
                "</div>" +
            "</div>";

        });
    }
    return viewListComment;
};

function generateSendComment(blogId) 
{
    var viewSendComment = "";
    viewSendComment += 
        "<div class='form-group'>" + 
            "<label class='sr-only' for='comment'></label>" +
            "<input type='text' onkeyup='showSendButton("+ blogId +")' class='form-control'  placeholder='Comment' id='comment" + blogId +"'> " +
        "</div>" +
        "<a role='button' style='display:none' onclick='addNewComment("+ blogId +")' class='btn btn-primary send-comment-"+ blogId + "' id='" + blogId + "'>Send</a>";
    return viewSendComment;
}

function addNewComment(blogId) 
{
    var commentContent = $("#comment"+blogId).val();
    $.ajaxSetup({
        headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    });
    $.ajax({
        type: "POST",
        url:'blog/comment/create',
        data: {
            'blogId': blogId,
            'comment_content': commentContent
        },
        success: function(data) {
            if(data.error == 0) {
                $("#list-comment-"+blogId).empty();
                $("#list-comment-"+blogId).append(generateListComment(data.listComments));
                $("#comment"+blogId).val('');
                $(".send-comment-"+blogId).hide();
            }else {
                alert(data.message)
            }
        }
    });
}

function showSendButton(blogId) 
{
    var commentContent = $("#comment"+blogId).val();
    if(commentContent != '' && commentContent != null) {
        $(".send-comment-"+blogId).show();
    }else {
        $(".send-comment-"+blogId).hide();
    }
}
