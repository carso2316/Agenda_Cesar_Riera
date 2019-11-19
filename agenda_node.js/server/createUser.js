const User = require('./models/userModel'),
      mongoose = require('mongoose');

mongoose.connect('mongodb://localhost/agendaNextU');

let db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', function() {});

let user = new User({
    id: Math.floor(Math.random() * 50),
    name: 'Cesar',
    password: '1234',
    birthday: Date('1994-05-23'),
    email: 'cesar@mail.com'
})
user.save(function(error) {
    if (error) {
        console.log("error: " + error);
    }
    console.log("Usuario registrado");
})