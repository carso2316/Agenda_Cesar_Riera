const mongoose = require('mongoose'),
      Schema = mongoose.Schema;

let userSchema = new Schema({
    id:{ type: Number, require: true, unique:true },
    name:{ type: String, require: true },
    password:{ type: String, require: true },
    birthday:{ type: Date, require: false },
    email:{ type: String, require: true},
})
let userModel = mongoose.model('Usuario', userSchema) //Usuario here will be "Usuarios" collection
module.exports = userModel;