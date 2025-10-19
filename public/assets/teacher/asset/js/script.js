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

console.log("welcome to notes");
showNotes();
//if a user add a storage add it to the local storage
let addBtn = document.getElementById("addBtn");
addBtn.addEventListener("click", function (e) {
  let addTxt = document.getElementById("addTxt");
  let addTitle = document.getElementById("addTitle");
  let notes = localStorage.getItem("notes");
  if (notes == null) {
    notesObj = [];
  } else {
    notesObj = JSON.parse(notes);
  }
  let myObj = {
    title: addTitle.value,
    text: addTxt.value,
  };
  notesObj.push(myObj);
  localStorage.setItem("notes", JSON.stringify(notesObj));
  addTxt.value = "";
  addTitle.value = "";
  //  console.log(notesObj);
  showNotes();
});
//function to show elements from local storage
function showNotes() {
  let notes = localStorage.getItem("notes");
  if (notes == null) {
    notesObj = [];
  } else {
    notesObj = JSON.parse(notes);
  }
  let html = "";
  notesObj.forEach(function (element, index) {
    html += `
            <div class="notecard my-2 mx-2 card" style="width: 18rem; height: 20px" >
                    <div class="card-body" style="background-color:#ffff">
                      <h5 class="card-title" data-bs-toggle="modal"
                      data-bs-target="#exampleModal3" 
                      >Title</h5>
                      <button id="${index}"onclick="deleteNote(this.id)" class="trash-bin" ><i class="fa-solid fa-trash"></i></button>
                    </div>
         </div>`;
  });
  let notesElm = document.getElementById("notes");
  if (notesObj.length != 0) {
    notesElm.innerHTML = html;
  } else {
    notesElm.innerHTML = ``;
  }
}

//function to delete node
function deleteNote(index) {
  // console.log('i am deleting');
  let notes = localStorage.getItem("notes");
  if (notes == null) {
    notesObj = [];
  } else {
    notesObj = JSON.parse(notes);
  }
  notesObj.splice(index, 1);
  localStorage.setItem("notes", JSON.stringify(notesObj));
  showNotes();
}

let search = document.getElementById("searchTxt");
search.addEventListener("input", function () {
  let inputVal = search.value.toLowerCase();
  //  console.log('Input event fired!',inputVal);
  let noteCards = document.getElementByClassName("noteCard");
  Array.from(noteCards).forEach(function (element) {
    let cardTxt = element.getElementByTagName("p")[0].innerText;
    if (cardTxt.includes(inputVal)) {
      //  element.getElementByClassName.display = "block"
      element.style.display = "block";
    } else {
      element.style.display = "none";
    }
  });
});

$(".show-more").click(function () {
  if ($(".text").hasClass("show-more-height")) {
    $(this).text("Less");
  } else {
    $(this).text("More");
  }

  $(".text").toggleClass("show-more-height");
});

// Sample chat messages for each user
const chatMessages = {
  "User 1": [
    { user: "User 1", message: "Hello!" },
    { user: "User 2", message: "How are you?" },
  ],
  "User 2": [
    { user: "User 2", message: "Hi there!" },
    { user: "User 1", message: "I am good, thanks!" },
  ],
  "User 3": [
    { user: "User 3", message: "Hey everyone!" },
    { user: "User 1", message: "What's up?" },
  ],
  "User 4": [
    { user: "User 4", message: "Hi there!" },
    { user: "User 2", message: "I am good, thanks!" },
  ],
  "User 5": [
    { user: "User 5", message: "Hey everyone!" },
    { user: "User 1", message: "What's up?" },
  ],
  "User 6": [
    { user: "User 6", message: "Hello!" },
    { user: "User 2", message: "How are you?" },
  ],
  "User 7": [
    { user: "User 7", message: "Hi there!" },
    { user: "User 1", message: "I am good, thanks!" },
  ],
  "User 8": [
    { user: "User 8", message: "Hey everyone!" },
    { user: "User 1", message: "What's up?" },
  ],
  "User 9": [
    { user: "User 9", message: "Hi there!" },
    { user: "User 2", message: "I am good, thanks!" },
  ],
  "User 10": [
    { user: "User 10", message: "Hi there!" },
    { user: "User 2", message: "I am good, thanks!" },
  ],
};

// Function to append messages to the chat box
function appendMessage(user, message, reaction, avatar) {
  const chatBox = document.getElementById("chat-box");
  const messageContainer = document.createElement("div");
  messageContainer.classList.add("user-message");

  // User Avatar
  const avatarImg = document.createElement("img");
  avatarImg.src = avatar;
  avatarImg.alt = "User Avatar";
  avatarImg.classList.add("user-avatar");
  messageContainer.appendChild(avatarImg);

  // Message content
  const messageContent = document.createElement("div");
  messageContent.innerHTML = `<strong>${user}:</strong> ${message} ${
    reaction ? `(${reaction})` : ""
  }`;
  messageContainer.appendChild(messageContent);

  chatBox.appendChild(messageContainer);
  chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll to the bottom
}

// Function to handle sending messages
function sendMessage() {
  const messageInput = document.getElementById("messageInput");
  const reactionBtn = document.getElementById("reactionBtn");
  const selectedUser = document.getElementById("selectedUserName").innerText;
  const message = messageInput.value;
  const reaction = reactionBtn.innerText;

  if (message.trim() !== "") {
    appendMessage("You", message, reaction, "your-avatar-url");
    messageInput.value = ""; // Clear the input field
    reactionBtn.innerText = "😊"; // Reset reaction button

    // Append the sent message to the chat messages of the selected user
    chatMessages[selectedUser].push({ user: "You", message, reaction });
  }
}

// Function to update the chat box based on the selected user
function updateChatBox(user) {
  const chatBox = document.getElementById("chat-box");
  chatBox.innerHTML = ""; // Clear previous messages

  const messages = chatMessages[user] || [];
  messages.forEach((msg) =>
    appendMessage(
      msg.user,
      msg.message,
      msg.reaction,
      chatMessages[user].avatar
    )
  );
}

// Set up event listener for send button
document
  .getElementById("sendMessageBtn")
  .addEventListener("click", sendMessage);

// Set up event listener for reaction button
document.getElementById("reactionBtn").addEventListener("click", function () {
  // You can implement a more complex logic for choosing reactions if needed
  const reactions = ["😊", "👍", "❤️", "😂", "😎"];
  const currentReaction = this.innerText;
  const nextReaction =
    reactions[(reactions.indexOf(currentReaction) + 1) % reactions.length];
  this.innerText = nextReaction;
});

// Set up event listener for user list items
const userListItems = document.querySelectorAll("#userList li");
userListItems.forEach((item) => {
  item.addEventListener("click", () => {
    const selectedUser = item.dataset.user;
    const selectedUserAvatar = item.dataset.avatar;
    document.getElementById("selectedUserName").innerText = selectedUser;
    document.getElementById("user-avatar").src = selectedUserAvatar;
    updateChatBox(selectedUser);
  });
});

// Display initial chat messages for the first user
updateChatBox("User 1");

// Calander js
document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");
  const myModal = new bootstrap.Modal(document.getElementById("form"));
  const dangerAlert = document.getElementById("danger-alert");
  const close = document.querySelector(".btn-close");

  const myEvents = JSON.parse(localStorage.getItem("events")) || [
    {
      id: uuidv4(),
      title: `Edit Me`,
      start: "2023-04-11",
      backgroundColor: "red",
      allDay: false,
      editable: false,
    },
    {
      id: uuidv4(),
      title: `Delete me`,
      start: "2023-04-17",
      end: "2023-04-21",

      allDay: false,
      editable: false,
    },
  ];

  const calendar = new FullCalendar.Calendar(calendarEl, {
    customButtons: {
      customButton: {
        text: "Add Event",
        click: function () {
          myModal.show();
          const modalTitle = document.getElementById("modal-title");
          const submitButton = document.getElementById("submit-button");
          modalTitle.innerHTML = "Add Event";
          submitButton.innerHTML = "Add Event";
          submitButton.classList.remove("btn-primary");
          submitButton.classList.add("btn-success");

          close.addEventListener("click", () => {
            myModal.hide();
          });
        },
      },
    },
    header: {
      center: "customButton", // add your custom button here
      right: "today, prev,next ",
    },
    plugins: ["dayGrid", "interaction"],
    allDay: false,
    editable: true,
    selectable: true,
    unselectAuto: false,
    displayEventTime: false,
    events: myEvents,
    eventRender: function (info) {
      info.el.addEventListener("contextmenu", function (e) {
        e.preventDefault();
        let existingMenu = document.querySelector(".context-menu");
        existingMenu && existingMenu.remove();
        let menu = document.createElement("div");
        menu.className = "context-menu";
        menu.innerHTML = `<ul>
          <li><i class="fas fa-edit"></i>Edit</li>
          <li><i class="fas fa-trash-alt"></i>Delete</li>
          </ul>`;

        const eventIndex = myEvents.findIndex(
          (event) => event.id === info.event.id
        );

        document.body.appendChild(menu);
        menu.style.top = e.pageY + "px";
        menu.style.left = e.pageX + "px";

        // Edit context menu

        menu
          .querySelector("li:first-child")
          .addEventListener("click", function () {
            menu.remove();

            const editModal = new bootstrap.Modal(
              document.getElementById("form")
            );
            const modalTitle = document.getElementById("modal-title");
            const titleInput = document.getElementById("event-title");
            const startDateInput = document.getElementById("start-date");
            const endDateInput = document.getElementById("end-date");
            const colorInput = document.getElementById("event-color");
            const submitButton = document.getElementById("submit-button");
            const cancelButton = document.getElementById("cancel-button");
            modalTitle.innerHTML = "Edit Event";
            titleInput.value = info.event.title;
            startDateInput.value = moment(info.event.start).format(
              "YYYY-MM-DD"
            );
            endDateInput.value = moment(info.event.end, "YYYY-MM-DD")
              .subtract(1, "day")
              .format("YYYY-MM-DD");
            colorInput.value = info.event.backgroundColor;
            submitButton.innerHTML = "Save Changes";

            editModal.show();

            submitButton.classList.remove("btn-success");
            submitButton.classList.add("btn-primary");

            // Edit button

            submitButton.addEventListener("click", function () {
              const updatedEvents = {
                id: info.event.id,
                title: titleInput.value,
                start: startDateInput.value,
                end: moment(endDateInput.value, "YYYY-MM-DD")
                  .add(1, "day")
                  .format("YYYY-MM-DD"),
                backgroundColor: colorInput.value,
              };

              if (updatedEvents.end <= updatedEvents.start) {
                // add if statement to check end date
                dangerAlert.style.display = "block";
                return;
              }

              const eventIndex = myEvents.findIndex(
                (event) => event.id === updatedEvents.id
              );
              myEvents.splice(eventIndex, 1, updatedEvents);

              localStorage.setItem("events", JSON.stringify(myEvents));

              // Update the event in the calendar
              const calendarEvent = calendar.getEventById(info.event.id);
              calendarEvent.setProp("title", updatedEvents.title);
              calendarEvent.setStart(updatedEvents.start);
              calendarEvent.setEnd(updatedEvents.end);
              calendarEvent.setProp(
                "backgroundColor",
                updatedEvents.backgroundColor
              );

              editModal.hide();
            });
          });

        // Delete menu
        menu
          .querySelector("li:last-child")
          .addEventListener("click", function () {
            const deleteModal = new bootstrap.Modal(
              document.getElementById("delete-modal")
            );
            const modalBody = document.getElementById("delete-modal-body");
            const cancelModal = document.getElementById("cancel-button");
            modalBody.innerHTML = `Are you sure you want to delete <b>"${info.event.title}"</b>`;
            deleteModal.show();

            const deleteButton = document.getElementById("delete-button");
            deleteButton.addEventListener("click", function () {
              myEvents.splice(eventIndex, 1);
              localStorage.setItem("events", JSON.stringify(myEvents));
              calendar.getEventById(info.event.id).remove();
              deleteModal.hide();
              menu.remove();
            });

            cancelModal.addEventListener("click", function () {
              deleteModal.hide();
            });
          });
        document.addEventListener("click", function () {
          menu.remove();
        });
      });
    },

    eventDrop: function (info) {
      let myEvents = JSON.parse(localStorage.getItem("events")) || [];
      const eventIndex = myEvents.findIndex(
        (event) => event.id === info.event.id
      );
      const updatedEvent = {
        ...myEvents[eventIndex],
        id: info.event.id,
        title: info.event.title,
        start: moment(info.event.start).format("YYYY-MM-DD"),
        end: moment(info.event.end).format("YYYY-MM-DD"),
        backgroundColor: info.event.backgroundColor,
      };
      myEvents.splice(eventIndex, 1, updatedEvent); // Replace old event data with updated event data
      localStorage.setItem("events", JSON.stringify(myEvents));
      console.log(updatedEvent);
    },
  });

  calendar.on("select", function (info) {
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");
    startDateInput.value = info.startStr;
    const endDate = moment(info.endStr, "YYYY-MM-DD")
      .subtract(1, "day")
      .format("YYYY-MM-DD");
    endDateInput.value = endDate;
    if (startDateInput.value === endDate) {
      endDateInput.value = "";
    }
  });

  calendar.render();

  const form = document.querySelector("form");

  form.addEventListener("submit", function (event) {
    event.preventDefault(); // prevent default form submission

    // retrieve the form input values
    const title = document.querySelector("#event-title").value;
    const startDate = document.querySelector("#start-date").value;
    const endDate = document.querySelector("#end-date").value;
    const color = document.querySelector("#event-color").value;
    const endDateFormatted = moment(endDate, "YYYY-MM-DD")
      .add(1, "day")
      .format("YYYY-MM-DD");
    const eventId = uuidv4();

    console.log(eventId);

    if (endDateFormatted <= startDate) {
      // add if statement to check end date
      dangerAlert.style.display = "block";
      return;
    }

    const newEvent = {
      id: eventId,
      title: title,
      start: startDate,
      end: endDateFormatted,
      allDay: false,
      backgroundColor: color,
    };

    // add the new event to the myEvents array
    myEvents.push(newEvent);

    // render the new event on the calendar
    calendar.addEvent(newEvent);

    // save events to local storage
    localStorage.setItem("events", JSON.stringify(myEvents));

    myModal.hide();
    form.reset();
  });

  myModal._element.addEventListener("hide.bs.modal", function () {
    dangerAlert.style.display = "none";
    form.reset();
  });
});
