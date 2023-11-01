import { CountUp } from "./countUp.js";
import { Odometer } from "./odemeter.js";

const duration = 6;

const n_students = document
    .getElementById("count-up-students")
    .getAttribute("data-number");
const n_courses = document
    .getElementById("count-up-courses")
    .getAttribute("data-number");
const n_companys = document
    .getElementById("count-up-companys")
    .getAttribute("data-number");

const students = new CountUp("count-up-students", n_students, {
    // prefix: "+ ",
    // suffix: " 🧑‍💻",
    duration,
    separator: ",",
    enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 2.0,
});

const courses = new CountUp("count-up-courses", n_courses, {
    // prefix: "+ ",
    // suffix: " 📚",
    duration,
    separator: ",",
    enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 2.0,
});

const companys = new CountUp("count-up-companys", n_companys, {
    // prefix: "+ ",
    // suffix: " 🏢",
    duration,
    separator: ",",
    enableScrollSpy: true,
    plugin: new Odometer({ duration: 2.3, lastDigitDelay: 0 }),
    duration: 2.0,
});

if (!students.error && !courses.error && !companys.error) {
    students.start();
    courses.start();
    companys.start();
} else {
    console.error(students.error, courses.error, companys.error);
}
