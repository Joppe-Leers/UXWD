let likeButton = document.getElementsByClassName("likeButton");
let likeStatus = document.getElementsByClassName("status");
let commentButton = document.getElementsByClassName("commentButton");
let commentContent = document.getElementsByClassName("commentContent");
let commentShow = document.getElementsByClassName("collapse");
let presentShow = document.getElementsByClassName("presentShow");

for (let i = 0; i < commentButton.length; i++) {
    commentButton[i].addEventListener('click', function () {
        document.getElementById('commentForm').submit()
        sendComment(commentContent[i].commentID.value, commentButton[i].parentElement.getAttribute("value"))
        username = getUsername()
        presentShow[i].insertAdjacentHTML("beforebegin", "<div class=\"py-2\"> <p class=\"font-weight-bold d-inline\">You: </p>\n" +
            "<p class=\"d-inline font-light\">" + commentContent[i].commentID.value + "</p></div>")
    }, true)
}

for (let i = 0; i < likeButton.length; i++) {
    likeButton[i].addEventListener('click', function() {
        likeButton[i].setAttribute("addClickHandleFlag","1")
        if(likeStatus[i].parentElement.getAttribute("value") == 1) {
            likeButton[i].className = "material-icons text-white likeButton"
            cancel_clicked(likeButton[i].parentElement.getAttribute("value"))
            likeStatus[i].parentElement.setAttribute("value",0)
        }
        else if(likeStatus[i].parentElement.getAttribute("value") == 0) {
            likeButton[i].className = "material-icons text-danger likeButton"
            accept_clicked(likeButton[i].parentElement.getAttribute("value"))
            likeStatus[i].parentElement.setAttribute("value",1)
        }
    }, true);
}

function getUsername() {
    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(base_url + "/getUsername")
        .catch(a => console.log(a));
}

function sendComment(comment, observationID) {
    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(base_url + "/sendComment/" + comment + "/" +observationID)
        .catch(a => console.log(a));
}

function accept_clicked(observationID) {

    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(base_url + "/changeLikeStatus/" + observationID)
        .catch(a => console.log(a));
}

function cancel_clicked(observationID) {
    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(base_url + "/cancelLikeStatus/" + observationID)
        .catch(a => console.log(a));
}

function getStatus() {
    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(base_url + "/checkUserLikeStatus/" + observationID)
        .catch(a => console.log(a));
}

function getNewButtons() {
    likeButton = document.getElementsByClassName("likeButton");
    likeStatus = document.getElementsByClassName("status");
    commentButton = document.getElementsByClassName("commentButton");
    commentContent = document.getElementsByClassName("commentContent");
    commentShow = document.getElementsByClassName("collapse");

}

function likeButtonListenerActivate() {
    for (let i = 0; i < likeButton.length; i++) {
        if (likeButton[i].getAttribute("addClickHandleFlag") !== "1") {
            likeButton[i].setAttribute("addClickHandleFlag","1")
            likeButton[i].addEventListener('click', function() {
                if(likeStatus[i].parentElement.getAttribute("value") == 1) {
                    likeButton[i].className = "material-icons text-white likeButton"
                    cancel_clicked(likeButton[i].parentElement.getAttribute("value"))
                    likeStatus[i].parentElement.setAttribute("value",0)
                }
                else if(likeStatus[i].parentElement.getAttribute("value") == 0) {
                    likeButton[i].className = "material-icons text-danger likeButton"
                    accept_clicked(likeButton[i].parentElement.getAttribute("value"))
                    likeStatus[i].parentElement.setAttribute("value",1)
                }
            }, true);
        }

    }

    for (let i = 0; i < commentButton.length; i++) {
        commentButton[i].addEventListener('click', function () {
            document.getElementById('commentForm').submit()
            sendComment(commentContent[i].commentID.value, commentButton[i].parentElement.getAttribute("value"))
            username = getUsername()
            commentShow[i].insertAdjacentHTML("afterend", "<div class=\"py-2\"> <h5 class=\"font-weight-bold d-inline\">You: </h5>\n" +
                "<h5 class=\"d-inline font-light\">" + commentContent[i].commentID.value + "</h5></div>")
        }, true)
    }
}

