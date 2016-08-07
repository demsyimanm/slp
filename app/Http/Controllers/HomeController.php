<?php
namespace App\Http\Controllers;
use Auth;
use Input;
use Request;
use App\User;
use Hash;
use App\Http\Requests;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Style\Border;
class HomeController extends Controller
{
    public function coba()
    {
        $objPHPPowerPoint = new PhpPresentation();
        $objPHPPowerPoint->removeSlideByIndex(0);
        // Create slide
        $oSlide = $objPHPPowerPoint->createSlide();
        // Title of slide
        $oSlide->setName('Title of the slide');
        // Create a shape (drawing)
        $shape = $oSlide->createDrawingShape();
        $shape->setName('PHPPresentation logo')
              ->setDescription('PHPPresentation logo')
              ->setPath('C:\xampp\htdocs\blog\vendor\phpoffice\phppresentation\samples\resources\phppowerpoint_logo.gif')
              ->setHeight(36)
              ->setOffsetX(10)
              ->setOffsetY(10);
        $shape->getShadow()->setVisible(true)
                           ->setDirection(45)
                           ->setDistance(10);
        // Create a shape (text)
        $shape = $oSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun('Thank you for using PHPPresentation!');
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
                           
        $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
        $oWriterPPTX->save('C:/xampp/htdocs/blog/vendor/phpoffice/phppresentation/samples/resources' . "/sample2.pptx");
        $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
        $oWriterODP->save('C:/xampp/htdocs/blog/vendor/phpoffice/phppresentation/samples/resources' . "/sample.odp");
        //Create new slide
        $oSlide = $objPHPPowerPoint->createSlide();
        $shape = $oSlide->createTableShape(1);
        $shape->setHeight(200);
        $shape->setWidth(600);
        $shape->setOffsetX(150);
        $shape->setOffsetY(100);
        $row = $shape->createRow();
        $row->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
                       ->setRotation(90)
                       ->setStartColor(new Color('FFE06B20'))
                       ->setEndColor(new Color('FFFFFFFF'));
        $cell = $row->nextCell();
        $cell->setColSpan(3);
        $cell->createTextRun('Title row')->getFont()->setBold(true)->setSize(16);
        $cell->getBorders()->getBottom()->setLineWidth(4)
                                        ->setLineStyle(Border::LINE_SINGLE)
                                        ->setDashStyle(Border::DASH_DASH);
        $row = $shape->createRow();
        $row->getFill()->setFillType(Fill::FILL_SOLID)
                       ->setStartColor(new Color('FFE06B20'))
                       ->setEndColor(new Color('FFE06B20'));
        $row->nextCell()->createTextRun('R2C1');
        $row->nextCell()->createTextRun('R2C2');
        $row->nextCell()->createTextRun('R2C3');
                
        $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
        $oWriterPPTX->save('C:/xampp/htdocs/blog/vendor/phpoffice/phppresentation/samples/resources' . "/sample2.pptx");
        $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
        $oWriterODP->save('C:/xampp/htdocs/blog/vendor/phpoffice/phppresentation/samples/resources' . "/sample.odp");
        //Create new slide
        $oSlide = $objPHPPowerPoint->createSlide();
        // Create a shape (drawing)
        $shape = $oSlide->createDrawingShape();
        $shape->setName('PHPPresentation logo')
              ->setDescription('PHPPresentation logo')
              ->setPath('C:\xampp\htdocs\blog\vendor\phpoffice\phppresentation\samples\resources\phppowerpoint_logo.gif')
              ->setHeight(36)
              ->setOffsetX(10)
              ->setOffsetY(10);
        $shape->getShadow()->setVisible(true)
                           ->setDirection(45)
                           ->setDistance(10);
        // Create a shape (text)
        $shape = $oSlide->createRichTextShape()
              ->setHeight(300)
              ->setWidth(600)
              ->setOffsetX(170)
              ->setOffsetY(180);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
        $textRun = $shape->createTextRun('Thank you 3');
        $textRun->getFont()->setBold(true)
                           ->setSize(60)
                           ->setColor( new Color( 'FFE06B20' ) );
        $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
        $oWriterPPTX->save('C:/xampp/htdocs/blog/vendor/phpoffice/phppresentation/samples/resources' . "/sample2.pptx");
        $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
        $oWriterODP->save('C:/xampp/htdocs/blog/vendor/phpoffice/phppresentation/samples/resources' . "/sample.odp");
    }
    protected $data = array();
    public function index()
    {   
        $this->data['username'] = "";
        $this->data['password'] = "";
        if(Auth::check())
        {
            $this->data['username'] = Auth::user()->username;
            $this->data['password'] = Auth::user()->password;
        }
        return view('home',$this->data);
    }
    public function login()
    {
        if (Request::isMethod('post'))
        {
            $credentials = Input::only('username','password');
            $this->data['username'] = Input::get('username');
            if (Auth::attempt($credentials,true))
            {
                return view('home');
            }
            return redirect('/');
        }
        else if (Request::isMethod('get'))
        {
            if (Auth::check())
            {
                return view('home');
            }
            return view('login');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function daftar()
    {
        $data = Input::all();
        User::create(array(
            'nip'       => $data['nip'],
            'role_id'   => 2,
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'nama'      => $data['name']
        ));
        return redirect('/');
    }
    
}