<?php 
$company = getCompanyInfo();
$order = $data['order']['order'];
$arrDet = $data['order']['detail'];
$subtotal = 0;
$discount = $order['coupon'];
$html="";
$arrRows = [];
foreach ($arrDet as $data) {
	$subtotalProduct =$data['quantity']*$data['price'];
	$subtotal+= $data['quantity']*$data['price'];
	$description="";
	if($data['topic'] == 1){
		$detail = json_decode($data['description']);
		$img ="";
		if(isset($detail->type)){
			$intWidth = floatval($detail->width);
			$intHeight = floatval($detail->height);
			$intMargin = floatval($detail->margin);
			$colorFrame =  $detail->colorframe ? $detail->colorframe : "";
			$material = $detail->material ? $detail->material : "";
			$marginStyle = $detail->style == "Flotante" || $detail->style == "Flotante sin marco interno" ? "Fondo" : "Paspartú";
			$borderStyle = $detail->style == "Flotante" ? "marco interno" : "bocel";
			$glassStyle = $detail->idType == 4 ? "Bastidor" : "Tipo de vidrio";
			$measureFrame = ($intWidth+($intMargin*2))."cm X ".($intHeight+($intMargin*2))."cm";
			if($detail->photo !=""){
				$img = '<a href="'.media().'/images/uploads/'.$detail->photo.'" target="_blank">Ver imagen</a><br>';
			}
			$description.='
					'.$img.'
					'.$detail->name.'
					<ul>
						<li><span class="fw-bold t-color-3">Referencia: </span>'.$detail->reference.'</li>
						<li><span class="fw-bold t-color-3">Color del marco: </span>'.$colorFrame.'</li>
						<li><span class="fw-bold t-color-3">Material: </span>'.$material.'</li>
						<li><span class="fw-bold t-color-3">Orientación: </span>'.$marginStyle.'</li>
						<li><span class="fw-bold t-color-3">Estilo de enmarcación: </span>'.$detail->style.'</li>
						<li><span class="fw-bold t-color-3">'.$marginStyle.': </span>'.$detail->margin.'cm</li>
						<li><span class="fw-bold t-color-3">Medida imagen: </span>'.$detail->width.'cm X '.$detail->height.'cm</li>
						<li><span class="fw-bold t-color-3">Medida marco: </span>'.$measureFrame.'</li>
						<li><span class="fw-bold t-color-3">Color del '.$marginStyle.': </span>'.$detail->colormargin.'</li>
						<li><span class="fw-bold t-color-3">Color del '.$borderStyle.': </span>'.$detail->colorborder.'</li>
						<li><span class="fw-bold t-color-3">'.$glassStyle.': </span>'.$detail->glass.'</li>
					</ul>
			';
		}else{
			if($detail->img !="" && $detail->img !=null){
				$img = '<a href="'.media().'/images/uploads/'.$detail->img.'" target="_blank">Ver imagen</a><br>';
			}
			$htmlDetail ="";
			$arrDet = $detail->detail;
			foreach ($arrDet as $d) {
				$htmlDetail.='<li><span class="fw-bold t-color-3">'.$d->name.': </span>'.$d->value.'</li>';
			}
			$description = $img.$detail->name.'<ul>'.$htmlDetail.'</ul>';
		}
	}else{
		$description=$data['description'];
		$flag = substr($data['description'], 0,1) == "{" ? true : false;
		if($flag){
			$arrData = json_decode($data['description'],true);
			$name = $arrData['name'];
			$varDetail = $arrData['detail'];
			$textDetail ="";
			foreach ($varDetail as $d) {
				$textDetail .= '<li><span class="fw-bold t-color-3">'.$d['name'].':</span> '.$d['option'].'</li>';
			}
			$description = $name.'<ul>'.$textDetail.'</ul>';
		}
	}
	$row = array(
		"reference"=>$data['reference'],
		"description"=>$description,
		"price"=>formatNum($data['price'],false),
		"qty"=>$data['quantity'],
		"subtotal"=>formatNum($subtotalProduct,false)
	);
	$html.='<td class="text-start w10">'.$data['reference'].'</td>';
	$html.='<td class="text-start w55">'.$description.'</td>';
	$html.='
		<td class="text-right w10">'.formatNum($data['price'],false).'</td>
		<td class="text-right w10">'.$data['quantity'].'</td>
		<td class="text-right w15">'.formatNum($subtotalProduct,false).'</td>
	';
	array_push($arrRows,$row);
}
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= $company['name'] ?></title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: auto; background: #fff; padding: 40px 30px; }
    h1 { color: #003366; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    td, th { padding: 10px; border-bottom: 1px solid #ddd; }
    .total { font-weight: bold; }
	a.button { display: inline-block; padding: 12px 24px; background: #0077cc; color: #fff; text-decoration: none; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Thank you for your purchase!</h1>
    <p>Here’s your receipt from <?= $company['name'] ?>:</p>
    <table>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Subtotal</th>
		</tr>
      	<?php foreach ($arrRows as $row) { ?>
		<tr>
			<td><?=$row['reference']?></td>
			<td><?=$row['description']?></td>
			<td><?=$row['price']?></td>
			<td><?=$row['qty']?></td>
			<td><?=$row['subtotal']?></td>
		</tr>
		<?php } ?>
		<tr>
			<td class="total">Subtotal</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="total"><?= formatNum(floor($subtotal),false)?></td>
		</tr>
		<tr>
			<td class="total">Discount</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="total"><?= formatNum(floor($discount),false)?></td>
		</tr>
		<tr>
			<td class="total">shippment</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="total"><?= formatNum($order['shipping'],false)?></td>
		</tr>
		<tr>
			<td class="total">Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td class="total"><?= formatNum($order['amount'],false)?></td>
		</tr>
    </table>
    <p>You can see your order in your profile</p>
  </div>
</body>
</html>