document.getElementById("send_friend_request").addEventListener("click",function() {
    let recieverID = document.querySelector('input[id="hidden_userID"]').value;
    sendRequest(recieverID);
});

function sendRequest(recieverID) {
    let baseUrl = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(baseUrl + "/sendFriendRequest/" + recieverID)
        .catch(a => console.log(a));
    window.location.reload();
}
