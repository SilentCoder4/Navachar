const path = require('path');
const http = require('http');
const express = require('express');
const socketio = require('socket.io');
const formatMessage = require('./src/utils/messages');
const { userJoin, getCurrentUser, userLeave, getRoomUser } = require('./src/utils/users');

const app = express();
const server = http.createServer(app);
const io = socketio(server);

//set static folder
app.use(express.static(path.join(__dirname, 'src/chat')));

const botName = 'Navachar'

//Run when client connects
io.on('connection', socket => {
    socket.on('joinRoom', ({ username, room }) => {
        const user = userJoin(socket.id, username, room);

        socket.join(user.room);

        //Welcome current user
        socket.emit('message', formatMessage(botName, 'Welcome to Navachar Discussion'));

        //broadcast users
        socket.broadcast
            .to(user.room)
            .emit(
                "message",
                formatMessage(botName, `${user.username} has joined the chat`)
            );

            // Send user and room info
            io.to(user.room).emit('roomUsers', {
                room: user.room,
                user: getRoomUser(user.room)
            });
    });

    //listen for chatmsg
    socket.on('chatMessage', msg => {
        const user = getCurrentUser(socket.id);


        io.to(user.room).emit('message', formatMessage(user.username, msg));
    });

    // run when user disconnects
    socket.on('disconnect', () => {
      const user = userLeave(socket.id);

      if (user) {
         io.to(user.room).emit(
            'message',
            formatMessage(botName, `${user.username} has left the chat!`)
         );

         // send users and room info
         io.to(user.room).emit('roomUsers', {
            room: user.room,
            users: getRoomUsers(user.room),
         });
      }
   });
});

const PORT = 3000 || process.env.PORT;

server.listen(PORT, () => console.log(`🎯 Server is running on PORT: ${PORT}`));