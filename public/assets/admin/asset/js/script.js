
    // const body = document.querySelector('body'),
    //   sidebar = body.querySelector('nav'),
    //   toggle = body.querySelector(".toggle"),
    //   searchBtn = body.querySelector(".search-box"),
    //   modeSwitch = body.querySelector(".toggle-switch"),
    //   modeText = body.querySelector(".mode-text");
    // toggle.addEventListener("click", () => {
    //   sidebar.classList.toggle("close");
    // })
    // searchBtn.addEventListener("click", () => {
    //   sidebar.classList.remove("close");
    // })
    // modeSwitch.addEventListener("click", () => {
    //   body.classList.toggle("dark");
    //   if (body.classList.contains("dark")) {
    //     modeText.innerText = "Light mode";
    //   } else {
    //     modeText.innerText = "Dark mode";
    //   }
    // });
    console.log('welcome to notes');
    showNotes();
    //if a user add a storage add it to the local storage
    let addBtn = document.getElementById("addBtn");
    addBtn.addEventListener("click", function(e) {
        let addTxt = document.getElementById("addTxt");
        let addTitle = document.getElementById("addTitle");
        let notes = localStorage.getItem("notes");
        if (notes == null) {
            notesObj = [];
        }
        else{
            notesObj=JSON.parse(notes);
        }
        let myObj = {
            title: addTitle.value,
            text: addTxt.value
        }
        notesObj.push(myObj);
        localStorage.setItem("notes",JSON.stringify(notesObj));
        addTxt.value="";
        addTitle.value="";
      //  console.log(notesObj);
        showNotes();
    });
    //function to show elements from local storage
    function showNotes(){
        let notes=localStorage.getItem("notes");
        if(notes == null){
            notesObj = [];
        }
        else{
            notesObj=JSON.parse(notes);
        }
        let html="";
        notesObj.forEach(function(element,index){
            html+=`
            <div class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px" >
                    <div class="card-body" style="background-color:#ffff">
                      <h5 class="card-title" data-bs-toggle="modal"
                      data-bs-target="#exampleModal3" 
                      >Title</h5>
                      <button id="${index}"onclick="deleteNote(this.id)" class="trash-bin" ><i class="fa-solid fa-trash"></i></button>
                    </div>
         </div>`;
        });
        let notesElm=document.getElementById("notes");
        if(notesObj.length!=0){
            notesElm.innerHTML=html;
        }
        else{
            notesElm.innerHTML=``;
        }
    }
    
    //function to delete node
    function deleteNote(index) {
       // console.log('i am deleting');
        let notes = localStorage.getItem("notes");
        if(notes == null) {
            notesObj = [];
        }
        else{
            notesObj=JSON.parse(notes);
        }
        notesObj.splice(index, 1);
        localStorage.setItem("notes",JSON.stringify(notesObj));
        showNotes();
    }
      
    let search = document.getElementById('searchTxt');
    search.addEventListener("input",function(){
        let inputVal = search.value.toLowerCase();
      //  console.log('Input event fired!',inputVal);
        let noteCards = document.getElementByClassName('noteCard');
        Array.from(noteCards).forEach(function(element){
            let cardTxt = element.getElementByTagName("p")[0].innerText;
            if(cardTxt.includes(inputVal)){
              //  element.getElementByClassName.display = "block"
              element.style.display ="block";
            }
            else{
                element.style.display ="none";
    
           }
        })
    
    })



  // Sample chat messages for each user
  const chatMessages = {
    'User 1': [
      { user: 'User 1', message: 'Hello!' },
      { user: 'User 2', message: 'How are you?' },
    ],
    'User 2': [
      { user: 'User 2', message: 'Hi there!' },
      { user: 'User 1', message: 'I am good, thanks!' },
    ],
    'User 3': [
      { user: 'User 3', message: 'Hey everyone!' },
      { user: 'User 1', message: 'What\'s up?' },
    ],
    'User 4': [
      { user: 'User 4', message: 'Hi there!' },
      { user: 'User 2', message: 'I am good, thanks!' },
    ],
    'User 5': [
      { user: 'User 5', message: 'Hey everyone!' },
      { user: 'User 1', message: 'What\'s up?' },
    ],
    'User 6': [
      { user: 'User 6', message: 'Hello!' },
      { user: 'User 2', message: 'How are you?' },
    ],
    'User 7': [
      { user: 'User 7', message: 'Hi there!' },
      { user: 'User 1', message: 'I am good, thanks!' },
    ],
    'User 8': [
      { user: 'User 8', message: 'Hey everyone!' },
      { user: 'User 1', message: 'What\'s up?' },
    ],
    'User 9': [
      { user: 'User 9', message: 'Hi there!' },
      { user: 'User 2', message: 'I am good, thanks!' },
    ],
    'User 10': [
      { user: 'User 10', message: 'Hi there!' },
      { user: 'User 2', message: 'I am good, thanks!' },
    ],
  };

  // Function to append messages to the chat box
  function appendMessage(user, message, reaction, avatar) {
    const chatBox = document.getElementById('chat-box');
    const messageContainer = document.createElement('div');
    messageContainer.classList.add('user-message');
    
    // User Avatar
    const avatarImg = document.createElement('img');
    avatarImg.src = avatar;
    avatarImg.alt = 'User Avatar';
    avatarImg.classList.add('user-avatar');
    messageContainer.appendChild(avatarImg);

    // Message content
    const messageContent = document.createElement('div');
    messageContent.innerHTML = `<strong>${user}:</strong> ${message} ${reaction ? `(${reaction})` : ''}`;
    messageContainer.appendChild(messageContent);

    chatBox.appendChild(messageContainer);
    chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll to the bottom
  }

  // Function to handle sending messages
  function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const reactionBtn = document.getElementById('reactionBtn');
    const selectedUser = document.getElementById('selectedUserName').innerText;
    const message = messageInput.value;
    const reaction = reactionBtn.innerText;

    if (message.trim() !== '') {
      appendMessage('You', message, reaction, 'your-avatar-url');
      messageInput.value = ''; // Clear the input field
      reactionBtn.innerText = '😊'; // Reset reaction button

      // Append the sent message to the chat messages of the selected user
      chatMessages[selectedUser].push({ user: 'You', message, reaction });
    }
  }

  // Function to update the chat box based on the selected user
  function updateChatBox(user) {
    const chatBox = document.getElementById('chat-box');
    chatBox.innerHTML = ''; // Clear previous messages

    const messages = chatMessages[user] || [];
    messages.forEach(msg => appendMessage(msg.user, msg.message, msg.reaction, chatMessages[user].avatar));
  }

  // Set up event listener for send button
  document.getElementById('sendMessageBtn').addEventListener('click', sendMessage);

  // Set up event listener for reaction button
  document.getElementById('reactionBtn').addEventListener('click', function () {
    // You can implement a more complex logic for choosing reactions if needed
    const reactions = ['😊', '👍', '❤️', '😂', '😎'];
    const currentReaction = this.innerText;
    const nextReaction = reactions[(reactions.indexOf(currentReaction) + 1) % reactions.length];
    this.innerText = nextReaction;
  });

  // Set up event listener for user list items
  const userListItems = document.querySelectorAll('#userList li');
  userListItems.forEach(item => {
    item.addEventListener('click', () => {
      const selectedUser = item.dataset.user;
      const selectedUserAvatar = item.dataset.avatar;
      document.getElementById('selectedUserName').innerText = selectedUser;
      document.getElementById('user-avatar').src = selectedUserAvatar;
      updateChatBox(selectedUser);
    });
  });

  // Display initial chat messages for the first user
  updateChatBox('User 1');


