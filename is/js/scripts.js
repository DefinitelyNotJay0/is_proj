/// SIDEBAR TOGGLE
let sidebarOpen = false;
const sidebar = document.getElementById('sidebar');

function openSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add('sidebar-responsive');
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove('sidebar-responsive');
    sidebarOpen = false;
  }
}

function closeCurrentPage() {
    window.open('', '_self'); // Open a blank page in the same tab
    window.close(); // Close the current page
}

function fetchData(url, elementId, keyName, defaultText = "N/A") {
  fetch(url)
      .then(response => {
          if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
          return response.json();
      })
      .then(data => {
          document.getElementById(elementId).textContent = data[keyName] ?? defaultText;
      })
      .catch(error => console.error(`Error fetching ${keyName}:`, error.message));
}

// Fetch Data for Different Cards
fetchData('php/get_data_customer.php', 'userCount', 'user_count');
fetchData('php/get_data_products.php', 'productCount', 'total_quantity');
fetchData('php/get_data_categories.php', 'categoryCount', 'category_count');


//Bar
fetch("get_bar_data.php")
  .then(response => response.json())
  .then(result => {
    const barChartOptions = {
      series: [{ data: result.data, name: "Products" }],
      chart: {
        type: "bar",
        height: 350,
        background: "transparent",
        toolbar: { show: false },
      },
      colors: ["#babae9bd", "#95bdebc9", "#99f3e7c5", "#b3f399c5", "#cfb291c5"],
      plotOptions: {
        bar: {
          distributed: true,
          borderRadius: 4,
          horizontal: false,
          columnWidth: "40%",
        },
      },
      dataLabels: { enabled: false },
      grid: {
        borderColor: "#55596e",
        yaxis: { lines: { show: true } },
        xaxis: { lines: { show: true } },
      },
      xaxis: {
        categories: result.categories,
        labels: {
          style: {
            colors: ["#FFFFFF", "#FFFFFF", "#FFFFFF", "#FFFFFF", "#FFFFFF"], // White text for better visibility
            fontSize: "14px", // Increase font size
            fontWeight: "bold", // Make text bold
          },
        },
        axisBorder: { color: "#FFFFFF" }, // White border for better contrast
        axisTicks: { color: "#FFFFFF" }, // White ticks for better visibility
      },
      yaxis: {
        title: {
          text: "Count",
          style: {
            color: "#FFFFFF", // White text for better visibility
            fontSize: "14px", // Increase font size
            fontWeight: "bold", // Make text bold
          },
        },
        labels: {
          style: {
            colors: "#FFFFFF", // White text for better visibility
            fontSize: "12px", // Increase font size
          },
        },
      },
      legend: {
        show: true, // Keep the legend visible
        fontSize: "10px", // Minimize the font size
        labels: {
          colors: "#FFFFFF", // White text for better visibility
        },
        position: "bottom", // Keep it at the bottom
      },
      tooltip: {
        theme: "dark", // Dark theme for better contrast
        style: {
          fontSize: "14px", // Increase font size
          fontWeight: "bold", // Make text bold
        },
      },
    };

    const barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
    barChart.render();
  })
  .catch((error) => console.error("Error fetching bar chart data:", error));


// Fetch data for the area chart
fetch("get_area_data.php")
  .then(response => response.json())
  .then(result => {
    console.log(result); // Debugging: Log the result to verify the data structure

    // Validate the data structure
    if (!result.months || !result.physical_store_sales || !result.online_sales) {
      throw new Error("Invalid data received from API");
    }

    // Configure the area chart
    const areaChartOptions = {
      series: [
        { name: "Physical Store Sales", data: result.physical_store_sales },
        { name: "Online Sales", data: result.online_sales },
      ],
      chart: { type: "area", height: 350, toolbar: { show: false } },
      colors: ["#99f3e7c5", "#b3f399c5"],
      xaxis: { 
        categories: result.months,
        labels: {
          style: {
            colors: ['white', 'white', 'white', 'white', 'white', 'white'], 
            fontSize: '13px',
            fontWeight: 'bold'
          }
        }
      },
      yaxis: { 
        title: { 
          text: "Sales Count",
          style: {
            color: '#FFFFFF', 
            fontSize: '14px',
            fontWeight: 'bold'
          }
        },
        labels: {
          style: {
            colors: '#FFFFFF' 
          }
        }
      },
      legend: {
        labels: {
          colors: '#FFFFFF', 
          fontSize: '14px'
        }
      },
      tooltip: { 
        theme: "dark",
        style: {
          fontSize: '14px', 
          fontWeight: 'bold' 
        },
        marker: {
          show: true, 
        },
        y: {
          formatter: function (value) {
            return value.toLocaleString(); 
          },
          title: {
            formatter: function (seriesName) {
              return seriesName + ": "; 
            }
          }
        }
      },
      dataLabels: {
        enabled: true,
        style: {
          colors: ["#ECCFAF", "#9BCFAF"], 
          fontSize: "12px",
          fontWeight: "bold"
        }
      },
      stroke: { curve: "smooth" }
    };

    // Render the area chart
    const areaChart = new ApexCharts(document.querySelector("#area-chart"), areaChartOptions);
    areaChart.render();
  })
  .catch(error => console.error("Error fetching sales data:", error.message));


fetch("get_data_pie.php")
  .then(response => response.json())
  .then(data => {
    console.log(data); // Debugging
    if (!data.categories || !data.data || data.categories.length === 0) {
      throw new Error("Invalid or empty pie chart data received");
    }

    var options = {
      chart: { type: "pie" },
      series: data.data, // Matches the "data" array from get_data_pie.php
      labels: data.categories, // Matches the "categories" array from get_data_pie.php
      title: { 
        text: "Most Purchased Products",
        align: "center",
        style: { fontSize: "16px", fontWeight: "bold", color: "#FFFFFF" }
      },
      legend: { labels: { colors: "#FFFFFF" } },
      dataLabels: { enabled: true, style: { colors: ["#000000"] } },
      tooltip: { theme: "dark" }
    };

    var chart = new ApexCharts(document.querySelector("#doughnut-chart"), options);
    chart.render();
  })
  .catch(error => console.error("Error fetching pie chart data:", error.message));