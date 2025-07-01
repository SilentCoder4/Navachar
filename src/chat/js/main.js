const chatForm = document.getElementById('chat-form');
const chatMessages = document.querySelector('.chat-messages');
const roomName = document.getElementById('room-name');
const userList = document.getElementById('users');

//Get username and room form url
const { username, room } = Qs.parse(location.search, {
    ignoreQueryPrefix: true
});

console.log(username, room);

const socket = io();

//join chat room
socket.emit('joinRoom', { username, room })

//Get room and user
socket.on('roomUsers', ({ room, users }) => {
    outputRoomName(room);
    outputUsers(users);
});

// Message from server
socket.on('message', (message) => {
    console.log(message);
    outputMessage(message);

    // Scroll down
    chatMessages.scrollTop = chatMessages.scrollHeight;
});

// Message submit
chatForm.addEventListener('submit', e => {
    e.preventDefault();

    const msg = e.target.elements.msg.value;

    // console.log(msg);

    //emiting msg to server
    socket.emit('chatMessage', msg);

    //clear input
    e.target.elements.msg.value = '';
    e.target.elements.msg.focus();
});


//output message to DOM
function outputMessage(message) {
    const div = document.createElement('div');
    div.classList.add('message');
    div.innerHTML = `<p class="meta">${message.username} <span>${message.time}</span></p>
<p class="text">${message.text}</p>`;

    document.querySelector('.chat-messages').appendChild(div);
}

//add room nname to dom
function outputRoomName(room) {
    roomName.innerText = room;
}

//add user to DOM
function outputUsers(users) {
if (Array.isArray(users)) {
      userList.innerHTML = users.map(user => `<li>${user.username}</li>`).join('');
    } else {
      userList.innerHTML = '<li>No users found</li>';
    }
  }

  outputUsers(users);