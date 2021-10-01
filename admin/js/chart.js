window.addEventListener('DOMContentLoaded', event => {

    const ctxArea = document.getElementById("myAreaChart");
    const ctxBar = document.getElementById("myBarChart");

    fetch('api/report.php?func=get_day_wise_orders', {})
        .then((r) => r = r.json())
        .then((r) => {
            const labels = r.data.map((e) => e.date);
            const data = r.data.map((e) => parseInt(e.count));

            const max = data.reduce(function (a, b) {
                return Math.max(a, b);
            }, 0);

            const myLineChart = new Chart(ctxArea, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Sessions",
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                        data: data,
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: Math.ceil(max + (max * .1)),
                                maxTicksLimit: 7
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)",
                            }
                        }],
                    },
                    legend: {
                        display: false
                    }
                }
            });

        });

    fetch('api/report.php?func=get_month_wise_orders', {}).then(r => r.json()).then((r) => {

        const labels = r.data.map((e) => e.month);
        const data = r.data.map((e) => parseInt(e.count));
        const max = data.reduce(function (a, b) {
            return Math.max(a, b);
        }, 0);
        const myLineChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: data,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: Math.ceil(max + (max * .1)),
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

    })

});