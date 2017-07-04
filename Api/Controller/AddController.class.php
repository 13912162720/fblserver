<?php
namespace Api\Controller;
use Think\Controller;
class AddController extends Controller{
	public function index(){
		$this->display();
	}
	public function get_cos_infomation(){
		header('Content-type:text/html;charset=utf-8');
		$model = M('Cos');
		$res = $model ->join('LEFT JOIN __BRAND__ on __COS__.brand_id=__BRAND__.id')-> field('cd_cos.id as cid,cosname,cd_brand.name as brandname,cd_brand.alias as brandalias,cd_cos.alias as cosalias,photo,description') ->limit(5) -> select();
		$this -> assign('res',$res);
		$this->display('index');
	}

	public function  get_upload_photo(){
		if($_FILES['photo']['error'] > 0){
			echo "错误：".$_FILES['photo']['error'].'<br>';
		}else{
			// 允许上传的图片后缀
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["photo"]["name"]);
			echo $_FILES["photo"]["size"];
			$extension = end($temp);     // 获取文件后缀名
			if ((($_FILES["photo"]["type"] == "image/gif")
			|| ($_FILES["photo"]["type"] == "image/jpeg")
			|| ($_FILES["photo"]["type"] == "image/jpg")
			|| ($_FILES["photo"]["type"] == "image/pjpeg")
			|| ($_FILES["photo"]["type"] == "image/x-png")
			|| ($_FILES["photo"]["type"] == "image/png"))
			&& ($_FILES["photo"]["size"] < 204800)   // 小于 200 kb
			&& in_array($extension, $allowedExts))
			{
				if ($_FILES["photo"]["error"] > 0)
				{
					echo "错误：: " . $_FILES["photo"]["error"] . "<br>";
				}
				else
				{
					echo "上传文件名: " . $_FILES["photo"]["name"] . "<br>";
					echo "文件类型: " . $_FILES["photo"]["type"] . "<br>";
					echo "文件大小: " . ($_FILES["photo"]["size"] / 1024) . " kB<br>";
					echo "文件临时存储的位置: " . $_FILES["photo"]["tmp_name"] . "<br>";
					
					// 判断当期目录下的 upload 目录是否存在该文件
					// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
					if (file_exists("D:\php\phpstudy\WWW\APP\fblapi\img\\" . $_FILES["photo"]["name"]))
					{
						echo $_FILES["photo"]["name"] . " 文件已经存在。 ";
					}
					else
					{
						// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
						move_uploaded_file($_FILES["photo"]["tmp_name"], "D:\php\phpstudy\WWW\APP\fblapi\img\\" . $_FILES["photo"]["name"]);
						echo "文件存储在: " . "upload/" . $_FILES["photo"]["name"];
					}
				}
			}
			else
			{
				echo "非法的文件格式";
			}
		}
	}
}