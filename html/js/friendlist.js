let accept_friend_list = document.getElementsByClassName("accept_friend");
let decline_friend_list = document.getElementsByClassName("decline_friend");
let delete_friend_list = document.getElementsByClassName("delete_friend");

for (let i = 0; i < accept_friend_list.length; i++) {
    accept_friend_list[i].addEventListener('click', function() {
        accept_clicked(accept_friend_list[i].parentElement.getAttribute("value"))
    }, true);
}

for (let i = 0; i < decline_friend_list.length; i++) {
    decline_friend_list[i].addEventListener('click', function() {
        decline_or_delete_clicked(decline_friend_list[i].parentElement.getAttribute("value"))
    }, true);
}

for (let i = 0; i < delete_friend_list.length; i++) {
    delete_friend_list[i].addEventListener('click', function() {
        decline_or_delete_clicked(delete_friend_list[i].getAttribute("value"))
    }, true);
}

function accept_clicked(idString) {
    let baseUrl = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(baseUrl + "/acceptFriendRequest/" + idString)
        .catch(a => console.log(a));
    window.location.reload(); //this line is not tested yet
}

function decline_or_delete_clicked(idString) {
    let baseUrl = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(baseUrl + "/declineFriendRequestOrDelete/" + idString)
        .catch(a => console.log(a));
    window.location.reload(); //this line is not tested yet
}