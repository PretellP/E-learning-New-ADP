Chart.defaults.global.defaultFontSize = 10;
Chart.defaults.global.defaultFontColor = "black";

(function () {
    // * First chart

    let ctx = $("#chart-student-status");

    let dataApproved = ctx.data("approved");
    let dataSuspended = ctx.data("suspended");
    let chart_student_status = document.getElementById("chart-student-status");
    let student_status = document.getElementById("student-status");

    if (dataApproved === 0 && dataSuspended === 0) {
        chart_student_status.remove();
        student_status.classList.add("student-status-active");
        student_status.classList.remove("student-status");
    } else {
        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [
                    `Aprobado #${dataApproved}`,
                    `Desaprobado #${dataSuspended}`,
                ],
                datasets: [
                    {
                        label: "Estado de Usuarios los últimos 30 días",
                        data: [dataApproved, dataSuspended],
                        backgroundColor: [
                            "rgb(83, 175, 190)",
                            "rgb(254, 92, 54)",
                        ],
                        responsive: true,
                    },
                ],
            },
            options: {
                cutoutPercentage: 55,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: "bottom",
                    labels: {
                        padding: 20,
                    },
                },
                tooltips: {
                    enabled: true,
                },
            },
        });
    }

    // * Second chart

    let brrs = $("#chart-types-of-users");

    let types_users = brrs.data("types");

    const {
        Administrador: administador,
        GerentedeSeguridadNexa: gerenteDeSeguridadNexa,
        IngenierodeSeguridadNexa: ingenieroDeSeguridadNexa,
        Instructor: instructor,
        Participante: participante,
        SoporteTecnico: soporteTecnico,
        SuperAdministrador: superAdministrador,
        Supervisor: supervisor,
    } = types_users;

    new Chart(brrs, {
        type: "bar",
        data: {
            labels: [
                `Administrador`,
                `G. Seguridad Nexa`,
                `I. Seguridad Nexa`,
                `Instructor`,
                // "Participante",
                `Soporte Tecnico`,
                `Super Administrador`,
                `Supervisor`,
            ],
            datasets: [
                {
                    label: "Usuarios",
                    data: [
                        administador,
                        gerenteDeSeguridadNexa,
                        ingenieroDeSeguridadNexa,
                        instructor,
                        // participante,
                        soporteTecnico,
                        superAdministrador,
                        supervisor,
                    ],
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                        "rgba(255, 205, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(201, 203, 207, 0.2)",
                    ],
                    borderColor: [
                        "rgb(255, 99, 132)",
                        "rgb(255, 159, 64)",
                        "rgb(255, 205, 86)",
                        "rgb(75, 192, 192)",
                        "rgb(54, 162, 235)",
                        "rgb(153, 102, 255)",
                        "rgb(201, 203, 207)",
                    ],
                    borderWidth: 3,
                    borderRadius: 4,
                    responsive: true,
                    maxWidth: 12,
                    hoverBorderWidth: 5,
                },
            ],
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: "top",
                labels: {
                    padding: 5,
                },
            },
            tooltips: {
                enabled: true,
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            indexAxis: "y",
        },
    });
})(jQuery);
