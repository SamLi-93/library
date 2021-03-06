<?php 

/**
 * 通过clientsoap调取数据
 */
class Webservice
{

	public $client;

	public function __construct()
	{
		$ws = "http://125.64.92.82:8181/libservices.asmx?WSDL";
		$ws = "http://121.40.224.47:8080/weixin/ws/WS_Library.asmx?WSDL";
		//libxml_disable_entity_loader(false);
		//$ws = "http://125.64.92.82:8181/SWLibServie.asmx";
   		$this->client = new SoapClient($ws);
	}

	public function showFunction(){
		$res = $this->client->__getFunctions();
		return $res;
	}


	/**
	 * 图书定位
	 * 条形码
	 */
	public function BookPosition($barcode){
		$arr['barcode'] = $barcode;
		$res = $this->client->BookPosition($arr);
		return $res;
	}

	/**
	 * 借书
	 * @param [type] $openid     [description]
	 * @param [type] $barcode    [description]
	 */
	public function BorrowBook($openid="",$barcode=""){
		$arr['barcode'] = $barcode;
		$arr['openid'] = $openid;
		$res = $this->client->BorrowBook($arr);
		return $res;
	}

	/**
	 * 根据openid获取用户信息
	 * @param [type] $openid [description]
	 */
	public function CreatedQRCode($openid){
		$arr['openid'] = $openid;
		$res = $this->client->CreatedQRCode($arr);
		return $res;
	}

	/**
	 * 根据openid判断是否绑定，绑定则返回用户信息
	 * @param [type] $openid [description]
	 */
	public function IsBinded($openid){
		$res = $this->client->IsBinded($openid);
		return $res;
	}

	/**
	 * 在借图书查询
	 * 参数：读者证号
	 * 返回结果：成功或失败、多本图书序列，图书序列内容包括：图书条码\题名\借阅日期\应还日期
	 * @param [type] $openid [description]
	 */
	public function QueryBorrowed($openid){
		$arr['openid'] = $openid;
		$res = $this->client->QueryBorrowed($arr);
		return $res;
	}

	/**
	 * 读者绑定
	 * 参数：读者证号、密码、微信号
	 * 返回结果：成功或失败，失败原因
	 * @param [type] $openid [description]
	 */
	public function ReaderBinding($readercode,$pwd,$openid){
		$arr['readercode'] = $readercode;
		$arr['pwd'] = $pwd;
		$arr['openid'] = $openid;
		$res = $this->client->ReaderBinding($arr);
		return $res;
	}

	/**
	 * 续借
	 * 参数：读者证号、密码、图书条码号
	 * 返回结果：成功或失败，失败原因
	 * @param [type] $openid  [description]
	 * @param [type] $barcode [description]
	 */
	public function RenewBook($openid,$barcode){
		$arr['openid'] = $openid;
		$arr['barcode'] = $barcode;
		$res = $this->client->RenewBook($arr);
		return $res;
	}

	/**
	 * 图书查询
	 * 参数：图书条码号 or 题名 or 责任者 or ISBN号
	 * 返回结果：成功或失败，多本图书序号，图书序列内容包括：图书条码\题名\责任者\借阅状态\层架编码
	 * @param [type] $barcode [description]
	 * @param [type] $title   [description]
	 * @param [type] $author  [description]
	 * @param [type] $isbn    [description]
	 */
	public function SearchBook($barcode,$title="",$author,$isbn){
		$arr['barcode'] = $barcode;
		$arr['title'] = $title;
		$arr['author'] = $author;
		$arr['isbn'] = $isbn;
		$res = $this->client->SearchBook($arr);
		return $res;
	}

	/**
	 * 转借
	 * 参数：读者证号、密码、图书条码号、原读者证号
	 * 返回结果：成功或失败，失败原因
	 * @param [type] $openid     [description]
	 * @param [type] $readercode [description]
	 * @param [type] $barcode    [description]
	 */
	public function Subtenancy($openid,$readercode,$barcode){
		$arr['openid'] = $openid;
		$arr['readercode'] = $readercode;
		$arr['barcode'] = $barcode;
		//var_dump($arr);
		$res = $this->client->Subtenancy($arr);
		return $res;
	}

	/**
	 * 解除绑定
	 * @param [type] $openid [description]
	 */
	public function ReaderRemoveBinding($openid){
		$arr['openid'] = $openid;
		$res = $this->client->ReaderRemoveBinding($arr);
		return $res;
	}

	/**
	 * 到期提醒
	 * $n 提前天数
	 * @param [type] $n [description]
	 */
	public function OverRemind($n){
		$n = 1;
		$res = $this->client->OverRemind($n);
		return $res;
	}

	/**
	 * 扣款提醒
	 */
	public function BooksFine(){
		$res = $this->client->BooksFine();
		return $res;
	}
	/**
	 * 新书通报
	 *参数：无参数 返回结果：成功或失败，图书条码、书名、作者、索书号、上架时间
	 * @param [type] $openid     [description]
	 * @param [type] $barcode    [description]
	 */
	public function GetNewBooks(){
		$res = $this->client->GetNewBooks();
		return $res;
	}
}
