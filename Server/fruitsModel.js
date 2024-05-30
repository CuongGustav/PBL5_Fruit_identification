const mongoose = require('mongoose');
const Schema = mongoose.Schema;
const ObjectId =  Schema.ObjectId;
const fruit = new Schema({
    id: {type: ObjectId},
    name: {type: String},
    weight: {type : Number}
});

module.exports = mongoose.models.fruits || mongoose.model('fruits', fruit)