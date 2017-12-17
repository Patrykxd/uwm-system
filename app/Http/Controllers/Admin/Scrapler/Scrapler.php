<?php

namespace App\Http\Controllers\Admin\Scrapler;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Storage;
use App\Http\Controllers\Controller;
use App\Http\Models\Seo\Projects;
use App\Http\Models\Seo\Groups;
use App\Http\Models\Seo\Links;
use App\Http\Requests\ProjectValidation;
use App\Http\Requests\LinkValidation;
use App\Http\Requests\XmlValidation;
use App\Providers\XmlParserProvider;
use Auth;
use Illuminate\Pagination\Paginator;

/**
 * Scrapler controller
 */
class Scrapler extends Controller {

    /**
     * scieżka do widoków controlera 
     * @var type 
     */
    private static $path_view = 'admin.scrapler.';
    private static $dir_xml = 'userfiles/xml/';
    private static $perpage = 50;

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * widok projectów
     * @return view
     */
    public function projects() {
        $data = array();
        if (Auth::user()->id == 1) {
            $data['projects'] = Projects::paginate(self::$perpage);
        } else {
            $data['projects'] = Projects::where('id_user', Auth::user()->id)->paginate(self::$perpage);
        }

        return view(self::$path_view . 'projects', $data);
    }

    public function newProject() {
        $data = array();
        $groups = Groups::all();

        foreach ($groups as $group) {
            $data['groups'][$group->groups_id] = $group->name_grups;
        }
        return view(self::$path_view . 'newProject', $data);
    }

    public function addProject(ProjectValidation $request) {

        $data = $request->all();
        $data['id_user'] = Auth::user()->id;
        $data['refers_projects_id'] = 0;

        Projects::create($data);

        return redirect('admin/scrapler/projects');
    }

    public function addProjectXML() {

        return view(self::$path_view . 'addProjectXML');
    }

    public function newProjectXml(Request $request) {

        $errors = array();
        if ($request->file('xml')->getClientSize() > 25 * 1024 * 1000) {
            $errors[] = 'Plik xml jest za duzy!';
            $success = array();
        } else {
            if ($request->hasFile('xml')) {
                $user_file = 'xml_' . Auth::user()->id;

                Storage::putFileAs($user_file, $request->file('xml'), 'plik.xml');

                $files = Storage::get($user_file . '/plik.xml');

                $xml = new XmlParserProvider();

                $result = $xml->parse($files);

                foreach ($result['project'] as $keyp => $project) {

                    if (!isset($project['name']) || empty($project['name'])) {
                        $errors[] = 'Invalid name projekt[' . $keyp . ']';
                        continue;
                    }
                    if (!isset($project['domain']) || empty($project['domain']) || filter_var($project['domain'], FILTER_VALIDATE_URL) == false) {
                        $errors[] = 'Invalid domain projekt[' . $keyp . ']';
                        continue;
                    }
                    if (!isset($project['link']) || empty($project['link']) || !is_array($project['link'])) {
                        $errors[] = 'Invalid link array projekt[' . $keyp . ']';
                        continue;
                    }

                    $data = array(
                        'id_user' => Auth::user()->id,
                        'groups_id' => '14', //import
                        'project_name' => $project['name'],
                        'refers_projects_id' => 0,
                        'project_domain' => $project['domain'],
                    );

                    $id = Projects::create($data)->id;

                    foreach ($project['link'] as $keyl => $link) {

                        if (!isset($link['url']) || empty($link['url'])) {
                            $errors[] = 'Invalid url projekt[' . $keyp . '] link[' . $keyl . ']';
                            continue;
                        }
                        if (!isset($link['pageUrl']) || empty($link['pageUrl'])) {
                            $errors[] = 'Invalid pageUrl projekt[' . $keyp . '] link[' . $keyl . ']';
                            continue;
                        }
                        if (!isset($link['anchor']) || empty($link['anchor'])) {
                            $errors[] = 'Niepoprawny name projekt[' . $keyp . '] link[' . $keyl . ']';
                            continue;
                        }

                        $ldata = array(
                            'projects_id' => $id,
                            'nofollow' => 'brak',
                            'server_response' => 'brak',
                            'url' => $project['domain'] . ( substr($project['domain'], -1) == '/' ? '' : '/' ) . $link['url'],
                            'refersto' => $link['pageUrl'],
                            'anchor' => $link['anchor'],
                        );
                        Links::create($ldata);
                    }
                }

                Storage::deleteDirectory($user_file);
                $success[] = 'Xml został dodany poprawnie';
            } else {
                $errors[] = 'Plik xml jest wymagan!';
                $success = array();
            }
        }
        return redirect('admin/scrapler/projects')->withErrors($errors)->with('success', $success);
    }

    public function editProject($id) {

        $data['project'] = Projects::where('id', $id)->first();

        $groups = Groups::all();

        foreach ($groups as $group) {
            $data['groups'][$group->groups_id] = $group->name_grups;
        }

        return view(self::$path_view . 'editProject', $data);
    }

    public function saveProject(ProjectValidation $request, $id) {

        $project = Projects::where('id', $id)->first();

        $data = $request->all();
        $data['id_user'] = Auth::user()->id;
        $data['id'] = $id;

        $project->update($data);

        return redirect('admin/scrapler/projects')->with('success', array('Edycja projektu została zapisana.'));
    }

    public function deleteProject($id) {

        $project = Projects::where('id', $id)->first();
        $project->links()->where('projects_id', $id)->delete();
        $project->delete();

        return redirect('admin/scrapler/projects')->with('success', array('Projekt został usunięty.'));
    }

    public function addLink($id) {

        $project = Projects::where('id', $id)->first();

        return view(self::$path_view . 'addLink', $project);
    }

    public function links($id) {
        $project = Projects::where('id', $id)->first();

        $data['links'] = $project->links()->paginate(self::$perpage);

        return view(self::$path_view . 'links', $data);
    }

    public function newLink(LinkValidation $request, $id) {
        $data = $request->all();

        $project = Projects::where('id', $id)->first();

        $data['projects_id'] = $project->id;
        $data['nofollow'] = 'null';
        $data['server_response'] = 'brak danych';
        $data['url'] = $project->project_domain . ( substr($project->project_domain, -1) == '/' ? '' : '/' ) . $data['url'];

        $project->links()->create($data);

        return redirect('admin/scrapler/project/id/' . $id)->with('success', array('Link został dodany'));
    }

    public function editLink($id) {

        $link = Links::where('links_id', $id)->first();
        $project = $link->projects()->where('id', $link->projects_id)->first();

        $link['domain'] = $project->project_domain;
        $link['id'] = $project->id;

        return view(self::$path_view . 'editLink', $link);
    }

    public function saveLink(LinkValidation $request, $id) {

        $link = Links::where('links_id', $id)->first();
        $project = $link->projects()->where('id', $link->projects_id)->first();

        $data = $request->all();

        $data['url'] = $project->project_domain . (substr($project->project_domain, -1) == '/' ? '' : '/' ) . $data['url'];

        $link->update($data);

        return redirect('admin/scrapler/link/edit-link/' . $id)->with('success', array('Zmiany zostały zapisane.'));
    }

    public function deleteLink($id) {
        $link = Links::where('links_id', $id)->first();
        $projects_id = $link->projects_id;
        $link->delete();

        return redirect('admin/scrapler/project/id/' . $projects_id)->with('success', array('Link zostały usunięty.'));
    }

}
