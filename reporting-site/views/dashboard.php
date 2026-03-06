<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Analytics Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
	<h2>Analytics Dashboard</h2>
    <nav><a href="/logout">Logout</a></nav>

    <h3>Raw Data Table</h3>
    <table id="analyticsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Payload</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>

    <h3>Performance Visualization</h3>
    <div style="width: 600px;">
        <canvas id="analyticsChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Promise.all([
            fetch('/api/static').then(r => r.json()),
            fetch('/api/performance').then(r => r.json()),
            fetch('/api/activity').then(r => r.json())
        ]).then(([staticData, perfData, activityData]) => {
            const allData = [...staticData, ...perfData, ...activityData];
            const tbody = document.getElementById('tableBody');

            allData.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${row.id}</td><td>${row.type}</td><td>${row.payload}</td>`;
                tbody.appendChild(tr);
            });

            const typeCounts = {
                static: staticData.length,
                performance: perfData.length,
                activity: activityData.length
            };

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Static', 'Performance', 'Activity'],
                    datasets: [{
                        data: [typeCounts.static, typeCounts.performance, typeCounts.activity],
                        backgroundColor: [
                            'rgba(255, 100, 130, 0.5)',
                            'rgba(55, 160, 235, 0.5)',
                            'rgba(255, 205, 85, 0.5)'
                        ]
                    }]
                }
            });
        });
    </script>
</body>
</html>
