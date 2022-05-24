let addFriendButtonList = document.getElementsByClassName("btn");
let groupName = php_groupName;

for (let i = 0; i < addFriendButtonList.length; i++) {
    addFriendButtonList[i].addEventListener('click', function() {
        accept_clicked(addFriendButtonList[i].parentElement.getAttribute("value"))
        addFriendButtonList[i].disabled=true
    }, true);
}

function accept_clicked(nameString) {
    let base_url = document.querySelector('input[id="hidden_base_url"]').value;
    fetch(base_url + "/addFriendToGroup/" + nameString.toString() + "/" + groupName)
        .catch(a => console.log(a));
}