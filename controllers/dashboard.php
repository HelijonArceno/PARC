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
            let ndate = now;
            ndate.setDate(ndate.getDate() + day_from_now)
            week[i] = [toYMD(ndate), sale_by_date(toYMD(ndate))];

            weekdates[i] = toYMD(ndate);
        }

        console.log(week)

        // alert(weekdates);

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

        $.ajax({
            url: '../models/dashboard/sales_top_by_date.php',
            type: 'GET',
            dataType: 'json',
            async: false,
            data:{
                date        : weekdates
            },
            success: function(response){
                let display;
                $.each(response, function(index, record){
                    display += `
                    <tr>
                        <td>
                        ${parseInt(index) + parseInt(1)}
                        </td>
                        <td>
                        ${record.total_sales}
                        </td>
                        <td>
                        ${record.brand}, ${record.product_name}, ${record.variant}, ${record.size} ${record.unit}
                        </td>
                    </tr>`
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

        KPI('today_total_sales','money', today);
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
                // responsive: true,
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
                type: 'doughnut',
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

    function sale_by_date_and(date){
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