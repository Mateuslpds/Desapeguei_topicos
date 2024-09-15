<?php

namespace App\Http\Controllers;

use App\Models\Objeto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Aws\Rekognition\RekognitionClient;

class ObjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $objeto = Objeto::all();
    
        return view('objetos.index'); 
    }
    
    public function pesquisa(Request $request)
    {
        $search = $request->input('search');
        $objetos = Objeto::where('nome', 'LIKE', "%".$search."%")
            ->get();
    
        return view('pesquisa', compact('objetos', 'search')); 
       /* $objetos = Objeto::join('users', 'objetos.user_id', '=', 'users.user_id')
            ->select('objetos.*', 'users.name as doadornome')
            ->get();*/;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('objetos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'cep' => 'required|string|max:10',
            'tipo' => 'required|exists:tipos,id',
        ]);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $imageContent = file_get_contents($requestImage->getRealPath());

            // Inicializar o cliente Rekognition
            $rekognition = new RekognitionClient([
                'version' => 'latest',
                'region'  => config('services.rekognition.region'),
                'credentials' => [
                    'key'    => config('services.rekognition.key'),
                    'secret' => config('services.rekognition.secret'),
                ],
            ]);

            // Analisar a imagem usando Rekognition
            $result = $rekognition->detectModerationLabels([
                'Image' => [
                    'Bytes' => $imageContent,
                ],
                'MinConfidence' => 75,
            ]);

            // Verificar se há labels impróprias
            $labels = $result->get('ModerationLabels');
            $prohibitedLabels = ['Weapons', 'Violence'];
            foreach ($labels as $label) {
                if (in_array($label['Name'], $prohibitedLabels)) {
                    \Log::info('Conteúdo impróprio detectado: ' . $label['Name'] . ' - Confiança: ' . $label['Confidence']);
                    return back()->withErrors(['imagem' => 'A imagem contém conteúdo impróprio.']);
                }
            }

            // Salvar a imagem no diretório
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now") . "." . $extension);
            $requestImage->move(public_path('img/objetos'), $imageName);

        } else {
            return back()->withErrors(['imagem' => 'A imagem não é válida.']);
        }

        // Salvar o objeto no banco de dados
        Objeto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'imagem' => $imageName,
            'cep' => $request->cep,
            'tipo_id' => $request->tipo,
            'user_id' => $request->user()->id
        ]);

        return redirect(route('objetos.index'))->with('msg', 'Objeto cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objeto = Objeto::find($id);

        return view('objetos.show')->with('objeto', $objeto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Objeto $objeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objeto $objeto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'imagem' => 'image|mimes:jpeg,png,jpg|max:2048',
            'cep' => 'required|string|max:10',
            'tipo' => 'required|exists:tipos,id',
        ]);

        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $requestImage = $request->file('imagem');
            $imageContent = file_get_contents($requestImage->getRealPath());

            // Inicializar o cliente Rekognition
            $rekognition = new RekognitionClient([
                'version' => 'latest',
                'region'  => config('services.rekognition.region'),
                'credentials' => [
                    'key'    => config('services.rekognition.key'),
                    'secret' => config('services.rekognition.secret'),
                ],
            ]);

            // Analisar a imagem usando Rekognition
            $result = $rekognition->detectModerationLabels([
                'Image' => [
                    'Bytes' => $imageContent,
                ],
                'MinConfidence' => 75,
            ]);

            // Verificar se há labels impróprias
            $labels = $result->get('ModerationLabels');
            $prohibitedLabels = ['Weapons', 'Violence'];
            foreach ($labels as $label) {
                if (in_array($label['Name'], $prohibitedLabels)) {
                    \Log::info('Conteúdo impróprio detectado: ' . $label['Name'] . ' - Confiança: ' . $label['Confidence']);
                    return back()->withErrors(['imagem' => 'A imagem contém conteúdo impróprio.']);
                }
            }

            // Salvar a nova imagem no diretório
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now") . "." . $extension);
            $requestImage->move(public_path('img/objetos'), $imageName);

            // Atualizar a imagem do objeto
            $objeto->imagem = $imageName;
        }

        // Atualizar os demais campos do objeto
        $objeto->nome = $request->nome;
        $objeto->descricao = $request->descricao;
        $objeto->cep = $request->cep;
        $objeto->tipo_id = $request->tipo;
        $objeto->save();

        return redirect(route('objetos.index'))->with('msg', 'Informações do objeto atualizadas com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objeto $objeto)
    {
        $objeto->delete();

        return redirect(route('objetos.index'))->with('msg', 'Objeto excluído com sucesso.');
    }
}
