<script>


    load_asset('modal');
    modal_load('global','modal','profile', null, null, 'php');
    
    $(document).ready(function(){
        ready();
    })
    $('.page_name').on('click', function(){
        window.location.href = 'home_page.php';
    });

    function ready(){

        let now = new Date();

        let today = toYMD(new Date());

        // used to store the dates
        let week = [];

        // retrieves the day number in a week from 0-6
        let weekday = now.getDay();
        week[weekday] = [toYMD(now), sale_by_date(today)];
        console.log(week[weekday]);

        // increments what to add
        let day_from_now = 0;

        // inserts day after today
        for(let i = weekday + 1; i < 7; i++){
            day_from_now++
            let ndate = new Date(today);
            ndate.setDate(ndate.getDate() + day_from_now)
            week[i] = [toYMD(ndate), sale_by_date(toYMD(ndate))];
        }

        day_from_now = 0;

        //inserts day before today
        for(let i = weekday - 1; i > -1; i--){
            day_from_now--
            let ndate = now;
            ndate.setDate(ndate.getDate() + day_from_now)
            week[i] = [toYMD(ndate), sale_by_date(toYMD(ndate))];
        }

        console.log(week)

        let yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        yesterday = toYMD(yesterday);

        let expiry_range = new Date();
        expiry_range.setDate(expiry_range.getDate() + 5 );
        expiry_range = toYMD(expiry_range);

        KPI('today_total_sales','money', today);
        KPI('today_products_sold','quantity', today);
        KPI('today_gross_profit','money', today);
        KPI('low_stock','quantity');
        KPI('no_stock','quantity');
        KPI('expired','quantity',today);
        KPI('near_expiry','quantity', today, expiry_range);
        KPI('daily_sales_performance','percent', yesterday, today);

        load_sales_graph();

        function load_sales_graph(){
            const width = $('#sales').width();
            const height = $('#sales').height();
            const marginTop = 20;
            const marginRight = 30;
            const marginBottom = 30;
            const marginLeft = 40;
        
        
            const x = d3.scaleUtc()
                .domain([new Date(week[0][0]),new Date(week[6][0])])
                .range([0,width]);
            
            const y = d3.scaleLinear()
                .domain([0,d3.max(week, d => d[1])])
                .range([height - marginBottom, marginTop]);
        
            const graph_container = d3.select('#sales');
        
            // Add the x-axis.
            graph_container.append("g")
                .attr("transform", `translate(${marginLeft},${height - marginBottom})`)
                .call(d3.axisBottom(x));
        
            // Add the y-axis.
            graph_container.append("g")
                .attr("transform", `translate(${marginLeft},0)`)
                .call(d3.axisLeft(y));  

        
            const line = d3.line()
                .x(d => x(new Date(d[0])) + marginLeft)
                .y(d => y(d[1]))
        
            graph_container.append("path")
                .datum(week)
                .attr('fill','none')
                .attr('stroke','white')
                .attr('stroke-width', 2)
                .attr('d',line);
        }
    }

    function toYMD(date){
        return date.getFullYear() +'-'+ (date.getMonth() + 1) +'-'+ date.getDate()
    }

    function KPI(type, display, date = null, date_end = null){

        $.ajax({
            url: '../models/dashboard/'+type+'.php',
            type: 'GET',
            dataType: 'json',
            data:{
                date        : date,
                date_end    : date_end
            },
            success: function(response){
                let output = ``;
                let data_output = response.kpi_data;

                if(data_output == null || data_output == 0){
                    output = 'No data available';
                }else{
                    if(display == 'quantity'){
                        output =`
                            ${data_output} products
                        `;;
                    }
    
                    if(display == 'money'){
                        output =`
                            PHP ${data_output}
                        `;
                    }
    
                    if(display == 'percent'){
                        output =`
                            ${Number(data_output).toFixed(2)}%
                        `;
                    } 
                }

            
                $('#'+type +' .data').html(output);
            },
            error: function(response){
                console.log('ERROR KPI: ' + response);
            }
        })
    }

    

    function sale_by_date(date){
        let output = 0;
        $.ajax({
            url: '../models/dashboard/sales_by_date.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data:{
                date        : date
            },
            success: function(response){
                if(response.sale){
                    output = response.sale;
                }
            },
            error: function(response){
                console.log('ERROR KPI: ' + response);
            }
        })
        return output;
    }
</script>