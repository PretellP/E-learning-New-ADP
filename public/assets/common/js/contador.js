import { CountUp } from "./../../home/js/countUp.js";
import { Odometer } from "./../../home/js/odemeter.js";

const duration = 6;

const n_users = document
    .getElementById("count-up-users")
    .getAttribute("data-number");
const n_companys = document
    .getElementById("count-up-companys")
    .getAttribute("data-number");
const n_courses_regular = document
    .getElementById("count-up-course-regular")
    .getAttribute("data-number");
const n_courses_free = document
    .getElementById("count-up-course-free")
    .getAttribute("data-number");
const n_events = document
    .getElementById("count-up-events")
    .getAttribute("data-number");


const users = new CountUp("count-up-users", n_users, {
    // prefix: "+ ",
    // suffix: " 🧑‍💻",
    duration,
    separator: ",",
    // enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 3.0,
});

const companys = new CountUp("count-up-companys", n_companys, {
    // prefix: "+ ",
    // suffix: " 🏢",
    duration,
    separator: ",",
    // enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 3.0,
});

const courses_regular = new CountUp("count-up-course-regular", n_courses_regular, {
    // prefix: "+ ",
    // suffix: " 📚",
    duration,
    separator: ",",
    // enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 3.0,
});

const courses_free = new CountUp("count-up-course-free", n_courses_free, {
    // prefix: "+ ",
    // suffix: " 📚",
    duration,
    separator: ",",
    // enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 3.0,
});


const events = new CountUp("count-up-events", n_events, {
    // prefix: "+ ",
    // suffix: " 📚",
    duration,
    separator: ",",
    // enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 3.0,
});


if (!users.error && !courses_regular.error && !companys.error && !courses_free.error && !events.error) {

    users.start();
    companys.start();
    courses_regular.start();
    courses_free.start();
    events.start();

} else {
    console.error(users.error, courses_regular.error, companys.error, courses_free.error, events.error);
}

