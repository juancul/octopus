<?php
//modificacion


require_once '../../../wp-blog-header.php';
get_header('shop');

if (isset($_REQUEST['order'])) {
	$order = new WC_Order($_REQUEST['order']);
	$data = $order->get_data();
	
	?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap');

#order_data {
    padding: 20px 10px;
    max-width: 900px;
    margin: 20px auto;
    border-radius: 10px;
    background: #fff;
    box-shadow: 2px 2px 6px hsla(0, 0%, 0%, .5);
    font-family: 'Montserrat', sans-serif;
}

#order_data * {
    font-family: 'Montserrat', sans-serif;
    color: #3a3a3a;
}

#order_data h1 {
    text-align: center;
    text-transform: uppercase;
    font-weight: bold;
}

#order_data h2,
#order_data p {
    text-align: center;
}

#order_data h3 {
    text-transform: uppercase;
    font-weight: bold;
    margin: 0;
}

#order_data table {
    margin: 20px 0;
    border-radius: 10px;
    overflow: hidden;
}

#order_data table,
#order_data th,
#order_data td {
    border: 1px solid hsl(0deg 0% 0% / 20%);
}

#order_data a {
    text-transform: uppercase;
    font-weight: bold;
    display: inline-block;
    padding: 10px 20px;
    line-height: 1;
    border-radius: 25px;
    box-shadow: inset 0 0 0 1px hsl(0deg 0% 0% / 20%);
    transition: .5s;
}

#order_data a:hover {
    box-shadow: inset 0 0 0 100px hsl(0deg 0% 0% / 20%);
}

.panel-wrap.woocommerce {
    padding: 0 10px;
}

#order_data .content_table {
    max-width: 100%;
    overflow: auto;
}

#order_data,
#order_data * {
    font-family: 'Montserrat', sans-serif;
    color: #3a3a3a;
    box-sizing: border-box;

}

#order_data table {
    width: 100%;
}

#order_data td {
    padding: 8px;
    font-size: 13px;
}

#order_data p {
    margin: 0;
    font-size: 13px;
}

#order_data table {
    border: 0;
    box-shadow: 0 0 0 1px hsl(0deg 0% 0% / 20%);
}

#order_data h1 {
    font-size: 40px;
    margin-bottom: 20px;
    line-height: 1.2em;
}

#order_data h2 {
    font-size: 29px;
    margin-bottom: 20px;
    line-height: 1.2em;
    font-weight: 300;
    text-transform: none;
}
</style>
<div class="panel-wrap woocommerce">
    <div id="order_data" class="panel woocommerce-order-data">
        <h1>
            <?php echo __('Gracias por su compra');?>
        </h1>
        <h2>
            <?php echo __('Detalles de Pedido')." #".$data['id'];?>
        </h2>
        <p>
            <?php echo __('Pago a través de Payvalida | PSE | Pagos en Efectivo.');?>
        </p>
        <div class="content_table">
            <table>
                <tr>
                    <td colspan="2">
                        <h3>
                            <?php echo __('Generales');?>
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Fecha de creación: ');?> </strong>
                    </td>
                    <td>
                        <?php echo $order->get_date_created();?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Estado: ');?> </strong>
                    </td>
                    <td>
                        <?php echo $order->get_status();?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h3>
                            <?php echo __('DATOS DEL COMPRADOR');?>
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Nombre:');?> </strong>
                    </td>
                    <td>
                        <?php echo $data["billing"]["first_name"]." ".$data["billing"]["last_name"]?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Address:');?> </strong>
                    </td>
                    <td>
                        <?php echo $data["billing"]["address_1"]?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('City:');?> </strong>
                    </td>
                    <td>
                        <?php echo $data["shipping"]["city"]?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('State:');?> </strong>
                    </td>
                    <td>
                        <?php echo $data["shipping"]["state"]?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Country:');?> </strong>
                    </td>
                    <td>
                        <?php echo $data["shipping"]["country"]?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Email:');?> </strong>
                    </td>
                    <td>
                        <?php echo $order->get_billing_email();?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong><?php echo __('Teléfono:');?> </strong>
                    </td>
                    <td>
                        <?php echo $order->get_billing_phone();?>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <p>
            <a href="/">
                <?php echo __('VOLVER AL COMERCIO');?>
            </a>
        </p>
    </div>
</div>
<?php
}else{
	echo '<h1><center>La petici&oacute;n es incorrecta! Hay un error en la firma digital.</center></h1>';
}


get_footer('shop');
?>