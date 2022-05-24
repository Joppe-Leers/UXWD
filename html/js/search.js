//let all = document.getElementById("All").addEventListener("click", AllClicked);
//let observation = document.getElementById("Observations").addEventListener("click", ObClicked);
//let group = document.getElementById("Groups").addEventListener("click", GroupsClicked);
//let user = document.getElementById("Users").addEventListener("click",UsersClicked);

let all = document.getElementById("All");
let observation = document.getElementById("Observations");
let group = document.getElementById("Groups");
let user = document.getElementById("Users");

all.addEventListener("click", AllClicked);
observation.addEventListener("click", ObClicked);
group.addEventListener("click", GroupsClicked);
user.addEventListener("click",UsersClicked);

document.getElementById("search").addEventListener("keyup", keyboardPressed);

//all = 0, observations = 1, groups = 2, users=3
let currentSearchFilter = 0;
let currentInput;
let baseUrl = document.querySelector('input[id="hidden_base_url"]').value;

function fetchSearchResult(){
    if(currentInput === ""){
        document.getElementById("placeholder_search_message").innerHTML = "<p>Start typing in the search bar.</p>";
        document.getElementById("observations_container").innerHTML = "<p></p>";
        document.getElementById("groups_container").innerHTML = "";
        document.getElementById("users_container").innerHTML = "";
    }
    else {
        document.getElementById("placeholder_search_message").innerHTML = "";
        switch (currentSearchFilter) {
            case 0:
                fetchObservations()
                fetchGroups()
                fetchUsers()
                break;
            case 1:
                fetchObservations()
                document.getElementById("groups_container").innerHTML = "";
                document.getElementById("users_container").innerHTML = "";
                break;
            case 2:
                fetchGroups()
                document.getElementById("observations_container").innerHTML = "";
                document.getElementById("users_container").innerHTML = "";
                break;
            case 3:
                fetchUsers()
                document.getElementById("groups_container").innerHTML = "";
                document.getElementById("observations_container").innerHTML = "";
                break;

        }
    }
}

function fetchObservations(){
    fetch(baseUrl + "/searchGetObservations/" + currentInput)
        .then(resp => resp.text())
        .then(data => document.getElementById("observations_container").innerHTML = data)
        .catch(a => console.log(a));
}

function fetchGroups(){
    fetch(baseUrl + "/searchGetGroups/" + currentInput)
        .then(resp => resp.text())
        .then(data => document.getElementById("groups_container").innerHTML = data)
        .catch(a => console.log(a));
}

function fetchUsers(){
    fetch(baseUrl + "/searchGetUsers/" + currentInput)
        .then(resp => resp.text())
        .then(data => document.getElementById("users_container").innerHTML = data)
        .catch(a => console.log(a));
}

function keyboardPressed() {
    currentInput = document.getElementById("search").value;
    // change all characters that are not in alpha numeric characters to SPACE
    currentInput = currentInput.replace(/[^a-zA-Z]/g,"SPACE");
    fetchSearchResult();
}

function AllClicked() {
    all.classList.add('active');
    observation.classList.remove('active');
    group.classList.remove('active');
    user.classList.remove('active');
    currentSearchFilter = 0;
    fetchSearchResult()
}

function ObClicked() {
    observation.classList.add('active');
    all.classList.remove('active');
    group.classList.remove('active');
    user.classList.remove('active');
    currentSearchFilter = 1;
    fetchSearchResult()
}

function GroupsClicked() {
    group.classList.add('active');
    observation.classList.remove('active');
    all.classList.remove('active');
    user.classList.remove('active');
    currentSearchFilter = 2;
    fetchSearchResult()
}

function UsersClicked() {
    user.classList.add('active');
    observation.classList.remove('active');
    group.classList.remove('active');
    all.classList.remove('active');
    currentSearchFilter = 3;
    fetchSearchResult()
}
