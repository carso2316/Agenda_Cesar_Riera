const Event = require('../models/eventModel'),
      express = require('express'),
      path = require('path'),
      Router = express.Router(),
      mongoose = require('mongoose')

mongoose.connect('mongodb://localhost/agendaNextU')

let db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', function() {});

Router.get('/all', function(req, res){
  let query = Event.find({});
  // Use native promises
  mongoose.Promise = global.Promise;
  let promise = query.exec();

  promise.then(function (eventData) {
    res.send(eventData);
  });

})

Router.post('/new', function(req, res){
  let eventRecord = new Event({
    id: Math.floor(Math.random() * 50),
    title : req.body.title,
    start : req.body.start,
    end : req.body.end
  })

  eventRecord.save((error) => {
      if (error) callback(error)
      console.log("Registro guardado");
  })

})

Router.post('/delete', function(req, res){
  Event.remove({id:req.body.id}, (error)=>{
    if(error) console.log(error)
    console.log("El registro fue eliminado exitosamente");
  })
})

Router.post('/update', function(req, res){
  let eventRecord = {
    title : req.body.title,
    start : req.body.start,
    end : req.body.end
  };
  let eventId = req.body.id;

  Event.update({id:eventId}, eventRecord, (error, result)=>{
    if(error) console.log(error)
    console.log(result);
  })

})

module.exports = Router;