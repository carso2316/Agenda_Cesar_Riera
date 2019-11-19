const mongoose = require('mongoose'),
      Schema = mongoose.Schema;

let eventSchema = new Schema({
    eventId: { type: Number, require: true, unique: true },
    title: { type: String, require: true },
    start: { type: Date, require: true },
    end: { type: Date, require: false },
    allDay: { type: Boolean, require: false }
})
let eventModel = mongoose.model('Event', eventSchema) //Usuario here will be "Usuarios" collection
module.exports = eventModel;