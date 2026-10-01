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
        let weekdates = [];

        // retrieves the day number in a week from 0-6
        let weekday = now.getDay();
        week[weekday] = [toYMD(now), sale_by_date(today)];
        console.log(week[weekday]);

        weekdates[weekday] = toYMD(now);

        // increments what to add
        let day_from_now = 0;

        // inserts day after today
        for(let i = weekday + 1; i < 7; i++){
            day_from_now++
            let ndate = new Date(today);
            ndate.setDate(ndate.getDate() + day_from_now)
            week[i] = [toYMD(ndate), sale_by_date(toYMD(ndate))];

            weekdates[i] = toYMD(ndate);
        }

        day_from_now = 0;

        //inserts day before today
        for(let i = weekday - 1; i > -1; i--){
            day_from_now--
            let ndate = new Date(now);
            ndate.setDate(ndate.getDate() + day_from_now)
            week[i] = [toYMD(ndate), sale_by_date(toYMD(ndate))];

            weekdates[i] = toYMD(ndate);
        }

        // alert('weekdates: ' + weekdates);
        console.log(week);

        let month_range = get_month_range(now);
        let year_range = get_year_range(now);

        $('#weekly_total_sales .data').html(sale_by_dates(weekdates));
        $('#monthly_total_sales .data').html(sale_by_range(month_range[0], month_range[1]));
        $('#annual_total_sales .data').html(sale_by_range(year_range[0], year_range[1]));

        // alert(sale_by_range('2024-09-21', '2026-10-3'));

        let sales_distribution_label = [];
        let sales_distribution_data = [];
        

        $.ajax({
            url: '../models/dashboard/sales_by_date_and_category.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data:{
                date        : weekdates
            },
            success: function(response){
                $.each(response, function(index, record){
                    // console.log(record.category +'|'+ record.total_sales);
                    sales_distribution_label[index] = record.category;
                    sales_distribution_data[index] = record.total_sales;
                });
                
            },
            error: function(response){
                console.log('ERROR KPI: ' + response);
            }
        })
        
                            // <div>
                            // php${record.total_sales.toLocaleString()}
                            // </div>
        $.ajax({
            url: '../models/dashboard/sales_top_by_date.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data:{
                date        : weekdates
            },
            success: function(response){
                let display = ``;
                $.each(response, function(index, record){

                let data_product_name = '';

                    let data_product_size = '';

                    if(record.brand != null){
                        data_product_name += record.brand + ', ';
                    }
                    if(record.product_name != null){
                        data_product_name += record.product_name;
                    }
                    if(record.variant != null){
                        data_product_name += ', '+ record.variant;
                    }
                    if(record.size != null){
                        data_product_name += ', '+ record.size;
                        data_product_size += record.size;
                    }
                    if(record.unit != null){
                        data_product_name += record.unit;
                        data_product_size += record.unit;
                    }

                    display += `
                    <div>
                        <div class="top_products_display">
                            <div>
                                #${parseInt(index) + parseInt(1)} - php${record.total_sales.toLocaleString()}
                            </div>

                            <div>
                                ${record.total_quantity} sold
                            </div>
                        </div>
                        <div class="top_products_detail">
                            [ ${record.product_code} ] ${data_product_name}
                        </div>
                    </div> 
                    `
                });
                $('#top_products').html(display);
                
            },
            error: function(response){
                console.log('ERROR KPI: ' + response);
            }
        })

        let yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        yesterday = toYMD(yesterday);

        let expiry_range = new Date();
        expiry_range.setDate(expiry_range.getDate() + 5 );
        expiry_range = toYMD(expiry_range);

        KPI('daily_total_sales','money', today);
        KPI('today_products_sold','quantity', today);
        KPI('today_gross_profit','money', today);
        KPI('low_stock','quantity');
        KPI('no_stock','quantity');
        KPI('expired','quantity',today);
        KPI('near_expiry','quantity', today, expiry_range);
        KPI('daily_sales_performance','percent', yesterday, today);

       
        load_sales_line_chart();
        load_sales_category_distribution_pie_chart();

        function load_sales_line_chart(){
            const daily_sales = document.getElementById('daily_sales_line_chart');
       
            new Chart(daily_sales, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Daily Sales',
                        data: week,
                        borderWidth: 1,
                    }]
                },
                options: {
                maintainAspectRatio: false,
                responsive: true,
                    scales: {
                        y: {
                        beginAtZero: true
                        }
                    }
                }
            });
        }
        function load_sales_category_distribution_pie_chart(){
            const daily_sales = document.getElementById('daily_sales_category_distribution_pie_chart');
            new Chart(daily_sales, {
                type: 'pie',
                data: {
                    labels: sales_distribution_label,
                    datasets: [{
                        label: 'Weekly Sales',
                        data: sales_distribution_data,
                        borderWidth: 1
                    },]
                },
                options: {
                    
                maintainAspectRatio: false,
                }
            });
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

    function sale_by_dates(p_dates){
        let output = 0;
        $.ajax({
            url: '../models/dashboard/sales_total_by_dates.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data:{
                date        : p_dates
            },
            success: function(response){
                output = response.totaL_sales;

                if(output == null || output == 0){
                    output = 'No data available';
                }else{
                    output = 'PHP ' + output.toLocaleString('en-US', {minimumFractionDigits: 2});
                }
                
            },
            error: function(response){
                console.log('ERROR KPI: ' + response);
            }
        })
        return output;
    }
    function sale_by_range(p_start, p_end){
        let output = 0;
        $.ajax({
            url: '../models/dashboard/sales_total_by_range.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data:{
                start       : p_start,
                end         : p_end,
            },
            success: function(response){
                output = response.totaL_sales;

                if(output == null || output == 0){
                    output = 'No data available';
                }else{
                    output = 'PHP ' + output.toLocaleString('en-US', {minimumFractionDigits: 2});
                }
                
            },
            error: function(response){
                console.log('ERROR KPI: ' + response);
            }
        })
        return output;
    }

    function get_month_range(date){
        let start = toYMD(new Date(date.getFullYear(), date.getMonth(), 1));
        let end = toYMD(new Date(date.getFullYear(), date.getMonth() + 1, 1));

        return [start, end];
    };

    function get_year_range(date){
        let start = toYMD(new Date(date.getFullYear(), 0, 1));
        let end = toYMD(new Date(date.getFullYear() + 1, 0, 1));

        return [start, end];
    };

    
</script>