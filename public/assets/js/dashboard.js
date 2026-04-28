/**
 * Dashboard KPI Charts - ApexCharts Sparkline Implementation
 * 
 * This file initializes sparkline charts for each KPI card in the dashboard.
 * Data is injected from PHP via data-* attributes in the HTML.
 * Includes: Sparklines, Main Area Chart, Donut Chart, and World Map.
 */

(function() {
  'use strict';

  /**
   * Color mapping for KPI themes
   * Maps theme names from PHP to hex color codes
   */
  const THEME_COLORS = {
    cyan: '#00FFCC',
    purple: '#8A2BE2',
    pink: '#FF007F',
    green: '#00E676',
    blue: '#00BFFF',
    orange: '#FF9800'
  };

  /**
   * Get color based on theme attribute
   * 
   * @param {string} theme - Theme name from data-theme attribute
   * @returns {string} Hex color code
   */
  function getColorByTheme(theme) {
    return THEME_COLORS[theme] || THEME_COLORS.cyan;
  }

  /**
   * Initialize all KPI chart containers (sparklines)
   */
  function initKpiCharts() {
    const chartContainers = document.querySelectorAll('.kpi-chart-container');

    if (!chartContainers.length) {
      console.warn('No KPI chart containers found');
      return;
    }

    chartContainers.forEach((container, index) => {
      const chartDataAttr = container.getAttribute('data-chart');
      
      if (!chartDataAttr) {
        console.warn('Container ' + index + ': No data-chart attribute found');
        return;
      }

      let chartData;
      try {
        chartData = JSON.parse(chartDataAttr);
      } catch (e) {
        console.error('Container ' + index + ': Failed to parse chart data', e);
        return;
      }

      const theme = container.getAttribute('data-theme') || 'cyan';
      const color = getColorByTheme(theme);

      const options = {
        series: [{
          data: chartData
        }],
        chart: {
          type: 'area',
          height: 60,
          sparkline: {
            enabled: true
          },
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
              enabled: true,
              delay: 150
            }
          }
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.05,
            stops: [0, 100]
          }
        },
        colors: [color],
        tooltip: {
          fixed: {
            enabled: false
          },
          x: {
            show: false
          },
          y: {
            title: {
              formatter: function(seriesName) {
                return '';
              }
            }
          },
          marker: {
            show: false
          }
        }
      };

      try {
        const chart = new ApexCharts(container, options);
        chart.render();
      } catch (e) {
        console.error('Container ' + index + ': Failed to render chart', e);
      }
    });
  }

/**
   * Initialize Main Analytics Chart (3-series mixed line/area time-series)
   */
  function initMainAnalyticsChart() {
    const container = document.getElementById('mainAnalyticsChart');
    
    if (!container) {
      console.warn('Main analytics chart container not found');
      return;
    }

    const newOrdersAttr = container.getAttribute('data-neworders');
    const revenueAttr = container.getAttribute('data-revenue');
    const orderValueAttr = container.getAttribute('data-ordervalue');

    if (!newOrdersAttr || !revenueAttr || !orderValueAttr) {
      console.warn('Main chart data attributes missing');
      return;
    }

    const newOrdersData = JSON.parse(newOrdersAttr);
    const revenueData = JSON.parse(revenueAttr);
    const orderValueData = JSON.parse(orderValueAttr);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const options = {
      series: [
        {
          name: 'New Orders',
          type: 'area',
          data: newOrdersData
        },
        {
          name: 'Revenue',
          type: 'area',
          data: revenueData
        },
        {
          name: 'Order Value',
          type: 'line',
          data: orderValueData
        }
      ],
      chart: {
        height: 300,
        type: 'line',
        toolbar: {
          show: false
        },
        animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 800
        }
      },
      colors: ['#00FFCC', '#8A2BE2', '#FF007F'],
      stroke: {
        curve: 'smooth',
        width: [3, 3, 2]
      },
      fill: {
        type: ['gradient', 'gradient', 'solid'],
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.2,
          stops: [0, 100]
        }
      },
      markers: {
        size: [0, 0, 5],
        strokeWidth: 2,
        strokeColors: '#fff',
        hover: {
          size: 8,
          sizeOffset: 3
        }
      },
      xaxis: {
        categories: months,
        labels: {
          style: {
            colors: '#9A9A9A'
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        }
      },
      yaxis: [
        {
          title: {
            text: 'New Orders',
            style: {
              color: '#00FFCC'
            }
          },
          labels: {
            style: {
              colors: '#00FFCC'
            }
          }
        },
        {
          opposite: true,
          title: {
            text: 'Order Value',
            style: {
              color: '#FF007F'
            }
          },
          labels: {
            style: {
              colors: '#FF007F'
            },
            formatter: function(value) {
              return '$' + value;
            }
          }
        }
      ],
      tooltip: {
        shared: true,
        intersect: false,
        theme: 'dark'
      },
      legend: {
        show: false
      },
      grid: {
        borderColor: 'rgba(224, 230, 237, 0.1)',
        strokeDashArray: 4
      }
    };

    try {
      const chart = new ApexCharts(container, options);
      chart.render();

      const filterToggle = document.querySelector('.filter-toggle');
      const filterDropdown = document.querySelector('.filter-dropdown');
      
      if (filterToggle && filterDropdown) {
        filterToggle.addEventListener('click', function(e) {
          e.stopPropagation();
          filterDropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
          if (!filterToggle.contains(e.target) && !filterDropdown.contains(e.target)) {
            filterDropdown.classList.remove('show');
          }
        });
        
        const checkboxes = filterDropdown.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function() {
            chart.toggleSeries(this.dataset.series);
          });
        });
      }
    } catch (e) {
      console.error('Failed to render main analytics chart', e);
    }
  }

  /**
   * Initialize Category Donut Chart
   */
  function initCategoryDonutChart() {
    const container = document.getElementById('categoryDonutChart');
    
    if (!container) {
      console.warn('Category donut chart container not found');
      return;
    }

    const categoriesAttr = container.getAttribute('data-categories');
    const salesAttr = container.getAttribute('data-sales');

    if (!categoriesAttr || !salesAttr) {
      console.warn('Donut chart data attributes missing');
      return;
    }

    const categories = JSON.parse(categoriesAttr);
    const sales = JSON.parse(salesAttr);

    const options = {
      series: sales,
      labels: categories,
      chart: {
        type: 'donut',
        height: 250,
        background: 'transparent',
        animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 800
        }
      },
      colors: ['#00FFCC', '#8A2BE2', '#FF007F'],
      stroke: {
        show: true,
        colors: ['#1A1A22'],
        width: 2
      },
      dataLabels: {
        enabled: false
      },
      plotOptions: {
        pie: {
          donut: {
            size: '70%',
            labels: {
              show: true,
              name: {
                color: '#E0E6ED'
              },
              value: {
                color: '#00FFCC',
                formatter: function(val) {
                  return '$' + parseInt(val).toLocaleString();
                }
              },
              total: {
                show: true,
                color: '#9A9A9A',
                formatter: function(w) {
                  const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                  return '$' + total.toLocaleString();
                }
              }
            }
          }
        }
      },
      legend: {
        position: 'bottom',
        labels: {
          colors: '#E0E6ED'
        }
      },
      theme: {
        mode: 'dark'
      }
    };

    try {
      const chart = new ApexCharts(container, options);
      chart.render();
    } catch (e) {
      console.error('Failed to render category donut chart', e);
    }
  }

  /**
   * Initialize Global Sales World Map
   */
  function initGlobalSalesMap() {
    const container = document.getElementById('globalSalesMap');
    
    if (!container) {
      console.warn('Global sales map container not found');
      return;
    }

    if (typeof jsVectorMap === 'undefined') {
      console.warn('jsVectorMap library not loaded');
      return;
    }

    try {
      const map = new jsVectorMap({
        selector: '#globalSalesMap',
        map: 'world',
        backgroundColor: 'transparent',
        draggable: true,
        zoomButtons: false,
        zoomOnScroll: false,
        regionStyle: {
          initial: {
            fill: 'rgba(0, 255, 204, 0.15)',
            stroke: 'rgba(0, 255, 204, 0.3)',
            strokeWidth: 0.5,
            fillOpacity: 1
          },
          hover: {
            fill: 'rgba(0, 255, 204, 0.3)'
          },
          selected: {
            fill: 'rgba(255, 0, 127, 0.3)'
          }
        },
        markers: [
          { name: 'United States', coords: [37.0902, -95.7129], style: { fill: '#00FFCC', stroke: '#fff', r: 8, filter: 'drop-shadow(0 0 6px #00FFCC)' } },
          { name: 'Germany', coords: [51.1657, 10.4515], style: { fill: '#8A2BE2', stroke: '#fff', r: 6, filter: 'drop-shadow(0 0 4px #8A2BE2)' } },
          { name: 'Japan', coords: [36.2048, 138.2529], style: { fill: '#FF007F', stroke: '#fff', r: 6, filter: 'drop-shadow(0 0 4px #FF007F)' } },
          { name: 'Brazil', coords: [-14.2350, -51.9253], style: { fill: '#00BFFF', stroke: '#fff', r: 5, filter: 'drop-shadow(0 0 4px #00BFFF)' } },
          { name: 'Australia', coords: [-25.2744, 133.7751], style: { fill: '#FF9800', stroke: '#fff', r: 5, filter: 'drop-shadow(0 0 4px #FF9800)' } },
          { name: 'United Kingdom', coords: [55.3781, -3.4360], style: { fill: '#00FFCC', stroke: '#fff', r: 5, filter: 'drop-shadow(0 0 4px #00FFCC)' } },
          { name: 'France', coords: [46.2276, 2.2137], style: { fill: '#8A2BE2', stroke: '#fff', r: 5, filter: 'drop-shadow(0 0 4px #8A2BE2)' } },
          { name: 'Canada', coords: [56.1304, -106.3468], style: { fill: '#FF007F', stroke: '#fff', r: 5, filter: 'drop-shadow(0 0 4px #FF007F)' } }
        ],
        markerStyle: {
          initial: {
            fill: '#00FFCC',
            stroke: '#fff',
            r: 6,
            fillOpacity: 1,
            filter: 'drop-shadow(0 0 6px #00FFCC)'
          },
          hover: {
            fill: '#FF007F',
            stroke: '#fff',
            r: 8,
            fillOpacity: 1,
            filter: 'drop-shadow(0 0 10px #FF007F)'
          }
        },
        markerLabelStyle: {
          initial: {
            fill: '#E0E6ED',
            fontWeight: 500,
            fontSize: 12
          }
        },
        onRegionTooltipShow: function(event, tooltip) {
          tooltip.css({
            backgroundColor: '#1A1A22',
            border: '1px solid #00FFCC',
            borderRadius: '4px',
            color: '#E0E6ED',
            padding: '8px 12px'
          });
        }
      });
    } catch (e) {
      console.error('Failed to initialize world map', e);
    }
  }

  /**
   * Initialize all dashboard components
   */
  function initDashboard() {
    initKpiCharts();
    initMainAnalyticsChart();
    initCategoryDonutChart();
    initGlobalSalesMap();
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboard);
  } else {
    initDashboard();
  }
})();