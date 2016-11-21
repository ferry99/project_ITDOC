<link href ="../assets/css/bootstrap.css" rel="stylesheet">
<link href ="../assets/css/mycss.css" rel="stylesheet">
<link href ="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../assets/css/formValidation.css"/>
<link href="../assets/css/bootstrap-table.css" rel="stylesheet">


<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type ="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/myjs.js"></script>
<script language="JavaScript" src="../assets/js/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
<script type="text/javascript" src="../assets/js/formValidation.js"></script>
<script type="text/javascript" src="../assets/js/framework/bootstrap.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap-table.js"></script>   
<script src="../assets/js/echarts/dist/echarts.min.js"></script>


<?php
require_once ('../config.php');
require_once(FUNC_PATH . '/mainvals.php');
require_once(FUNC_PATH . '/connectdb.php');  
require_once(FUNC_PATH . '/readvals.php');  
require_once(FUNC_PATH . '/readcookie.php');
require_once(FUNC_PATH . '/checksession.php');                   

require_once (VSM_PATH . '/stemmerQ.php');
require_once (VSM_PATH . '/vsm_searching1.php');
require_once (VSM_PATH . '/vsm_test.php');

$id_document = $_GET['id'];

$bobot = testW($id_document);

foreach ($bobot as $key => $value) {
	$term[] = $key;
	$w[] = $value;
}



?>




<body class="nav-md">
    <div class="container body">

			<div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Weight Terms Bar</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="echart_bar_horizontal" style="height:500px;"></div>

                  </div>
                </div>
              </div>               
    </div>
</body>


<script type="text/javascript">
	

	 $(document).ready(function() {

      	var theme = {
          color: [
              '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
              '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
              itemGap: 8,
              textStyle: {
                  fontWeight: 'normal',
                  color: '#408829'
              }
          },

          dataRange: {
              color: ['#1f610a', '#97b58d']
          },

          toolbox: {
              color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
              backgroundColor: 'rgba(0,0,0,0.5)',
              axisPointer: {
                  type: 'line',
                  lineStyle: {
                      color: '#408829',
                      type: 'dashed'
                  },
                  crossStyle: {
                      color: '#408829'
                  },
                  shadowStyle: {
                      color: 'rgba(200,200,200,0.3)'
                  }
              }
          },

          dataZoom: {
              dataBackgroundColor: '#eee',
              fillerColor: 'rgba(64,136,41,0.2)',
              handleColor: '#408829'
          },
          grid: {
              borderWidth: 0
          },

          categoryAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },

          valueAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitArea: {
                  show: true,
                  areaStyle: {
                      color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },
          timeline: {
              lineStyle: {
                  color: '#408829'
              },
              controlStyle: {
                  normal: {color: '#408829'},
                  emphasis: {color: '#408829'}
              }
          },

          k: {
              itemStyle: {
                  normal: {
                      color: '#68a54a',
                      color0: '#a9cba2',
                      lineStyle: {
                          width: 1,
                          color: '#408829',
                          color0: '#86b379'
                      }
                  }
              }
          },
          map: {
              itemStyle: {
                  normal: {
                      areaStyle: {
                          color: '#ddd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  },
                  emphasis: {
                      areaStyle: {
                          color: '#99d2dd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  }
              }
          },
          force: {
              itemStyle: {
                  normal: {
                      linkStyle: {
                          strokeColor: '#408829'
                      }
                  }
              }
          },
          chord: {
              padding: 4,
              itemStyle: {
                  normal: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  },
                  emphasis: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  }
              }
          },
          gauge: {
              startAngle: 225,
              endAngle: -45,
              axisLine: {
                  show: true,
                  lineStyle: {
                      color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                      width: 8
                  }
              },
              axisTick: {
                  splitNumber: 10,
                  length: 12,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              axisLabel: {
                  textStyle: {
                      color: 'auto'
                  }
              },
              splitLine: {
                  length: 18,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              pointer: {
                  length: '90%',
                  color: 'auto'
              },
              title: {
                  textStyle: {
                      color: '#333'
                  }
              },
              detail: {
                  textStyle: {
                      color: 'auto'
                  }
              }
          },
          textStyle: {
              fontFamily: 'Arial, Verdana, sans-serif'
          }
      };



 var echartBar = echarts.init(document.getElementById('echart_bar_horizontal'),theme);

      echartBar.setOption({
        title: {
          text: 'Graph',
          subtext: 'Term Graph'
        },
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          x: 100,
          data: ['2015', '2016']
        },
        toolbox: {
          show: true,
          feature: {
            saveAsImage: {
              show: true,
              title: "Save Image"
            }
          }
        },
        calculable: true,
        xAxis: [{
          type: 'value',
          boundaryGap: [0, 0.01]
        }],
        yAxis: [{
          type: 'category',
          data: <?php echo json_encode($term); ?>
        }],
        series: [{
          name: 'Bobot',
          type: 'bar',
          data: <?php echo json_encode($w); ?>
        }]
      });
      
      });
</script>