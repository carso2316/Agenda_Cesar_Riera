const http        = require('http'),
      path        = require('path'),
      login       = require('./login'),
      eventRouter = require('./event'),
      express     = require('express'),
      bodyParser  = require('body-parser'),
      mongoose    = require('mongoose'),
      cors        = require('cors');

const PORT = 3000;
const app = express();

const Server = http.createServer(app);

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({extended: true}));
app.use(cors());
app.use('/login', login);
app.use('/events', eventRouter);

app.use(express.static(path.join(__dirname, '../')+'client'))

mongoose.connect('mongodb://localhost/agendaNextU');

let db = mongoose.connection;
db.on('error', console.error.bind(console, 'connection error:'));
db.once('open', function() {});

Server.listen(PORT, function(){
    console.log(`Server is listening on port: ${PORT}`);
})