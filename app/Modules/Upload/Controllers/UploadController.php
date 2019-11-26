<?php

namespace App\Modules\Upload\Controllers;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Input;
use Collective\Html\FormFacade as Form;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

use Auth;
use DB;
use File;
use Validator;
use Datatables;

use App\Modules\Upload\Models\Upload;

class UploadController extends BackendController
{
	public $show_action = true;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'path', 'extension', 'caption', 'user_id'];



	/**
	 * Display a listing of the Uploads.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$title = 'Uploaded images & files';
		return view("Upload::index", compact('title'));
	}

	/**
     * Get file
     *
     * @return \Illuminate\Http\Response
     */
    public function get_file($hash, $name)
    {
        $upload = Upload::where("hash", $hash)->first();

        // Validate Upload Hash & Filename
        if(!isset($upload->id) || $upload->name != $name) {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access 1"
            ]);
        }

        if($upload->public == 1) {
            $upload->public = true;
        } else {
            $upload->public = false;
        }

        // Validate if Image is Public
        if(!$upload->public && !isset(Auth::user()->id)) {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access 2",
            ]);
        }

        if($upload->public || Auth::user()->hasRole('SUPER_ADMIN|ADMIN') || Auth::user()->id == $upload->user_id) {

            $path = $upload->path;

            if(!File::exists($path))
                abort(404);

            // Check if thumbnail
            $size = Input::get('s');
            if(isset($size)) {
                if(!is_numeric($size)) {
                    $size = 150;
                }
                $thumbpath = storage_path("./".basename($upload->path)."-".$size."x".$size);

                if(File::exists($thumbpath)) {
                    $path = $thumbpath;
                } else {
                    // Create Thumbnail
                    $this->createThumbnail($upload->path, $thumbpath, $size, $size, "transparent");
                    $path = $thumbpath;
                }
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $download = Input::get('download').'YES';
            if($download == 'YES') {
                return response()->download($path, $upload->name);
            } else {
                $response = FacadeResponse::make($file, 200);
                $response->header("Content-Type", $type);
            }

            return $response;
        } else {
            return response()->json([
                'status' => "failure",
                'message' => "Unauthorized Access 3"
            ]);
        }
    }

    /**
     * Upload fiels via DropZone.js
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_files() {

		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') ) {
			$input = Input::all();

			if(Input::hasFile('file')) {

				$rules = array(
					'file' => 'mimes:jpg,jpeg,bmp,png,pdf|max:3000',
				);
				$validation = Validator::make($input, $rules);
				if ($validation->fails()) {
					return response()->json($validation->errors()->first(), 400);
				}

				$file = Input::file('file');



				$folder = storage_path('uploads');

				$filename = $file->getClientOriginalName();

				$date_append = date("Y-m-d-His-");
				$upload_success = Input::file('file')->move($folder, $date_append.rand(1000,9999).$filename);

				if( $upload_success ) {

					// Get public preferences
					// config("laraadmin.uploads.default_public")
					$public = Input::get('public');
					if(isset($public)) {
						$public = true;
					} else {
						$public = false;
					}

					$upload = Upload::create([
						"name" => $filename,
						"path" => $folder.DIRECTORY_SEPARATOR.$date_append.$filename,
						"extension" => pathinfo($filename, PATHINFO_EXTENSION),
						"caption" => "",
						"hash" => "",
						"public" => $public,
						"user_id" => Auth::user()->id
					]);
					// apply unique random hash to file
					while(true) {
						$hash = strtolower(str_random(20));
						if(!Upload::where("hash", $hash)->count()) {
							$upload->hash = $hash;
							break;
						}
					}
					$upload->save();

					return response()->json([
						"status" => "success",
						"upload" => $upload
					], 200);
				} else {
					return response()->json([
						"status" => "error"
					], 400);
				}
			} else {
				return response()->json('error: upload file not found.', 400);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Unauthorized Access"
			]);
		}
    }

    /**
     * Get all files from uploads folder
     *
     * @return \Illuminate\Http\Response
     */
    public function uploaded_files()
    {
		$uploads = Upload::all();
		$uploads2 = array();
		foreach ($uploads as $upload) {
			$u = (object) array();
			$u->id = $upload->id;
			$u->name = $upload->name;
			$u->extension = $upload->extension;
			$u->hash = $upload->hash;
			$u->public = $upload->public;
			$u->caption = $upload->caption;
			$u->user = $upload->user->name;

			$uploads2[] = $u;
		}

		return response()->json(['uploads' => $uploads2]);
    }

    /**
     * Update Uploads Caption
     *
     * @return \Illuminate\Http\Response
     */
    public function update_caption()
    {
        $file_id = Input::get('file_id');
		$caption = Input::get('caption');

		$upload = Upload::find($file_id);
		if(isset($upload->id)) {
			if($upload->user_id == Auth::user()->id ||  Auth::user()->hasRole('SUPER_ADMIN|ADMIN')) {

				// Update Caption
				$upload->caption = $caption;
				$upload->save();

				return response()->json([
					'status' => "success"
				]);

			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Upload not found"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Upload not found"
			]);
		}
    }

    /**
     * Update Uploads Filename
     *
     * @return \Illuminate\Http\Response
     */
    public function update_filename()
    {
		$file_id = Input::get('file_id');
		$filename = Input::get('filename');

		$upload = Upload::find($file_id);
		if(isset($upload->id)) {
			if($upload->user_id == Auth::user()->id || Auth::user()->hasRole('SUPER_ADMIN|ADMIN')) {

				// Update Caption
				$upload->name = $filename;
				$upload->save();

				return response()->json([
					'status' => "success"
				]);

			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Unauthorized Access 1"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Upload not found"
			]);
		}
    }

    /**
     * Update Uploads Public Visibility
     *
     * @return \Illuminate\Http\Response
     */
    public function update_public()
    {
		$file_id = Input::get('file_id');
		$public = Input::get('public');
		if(isset($public)) {
			$public = true;
		} else {
			$public = false;
		}

		$upload = Upload::find($file_id);
		if(isset($upload->id)) {
			if($upload->user_id == Auth::user()->id || Auth::user()->hasRole('SUPER_ADMIN|ADMIN')) {

				// Update Caption
				$upload->public = $public;
				$upload->save();

				return response()->json([
					'status' => "success"
				]);

			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Unauthorized Access 1"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Upload not found"
			]);
		}
    }

    /**
     * Remove the specified upload from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_file()
    {
        $file_id = Input::get('file_id');

		$upload = Upload::find($file_id);
		if(isset($upload->id)) {
			if($upload->user_id == Auth::user()->id || Auth::user()->hasRole('SUPER_ADMIN')) {

				// Update Caption
				$upload->delete();

				return response()->json([
					'status' => "success"
				]);

			} else {
				return response()->json([
					'status' => "failure",
					'message' => "Unauthorized Access 1"
				]);
			}
		} else {
			return response()->json([
				'status' => "failure",
				'message' => "Upload not found"
			]);
		}
    }

    public function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height, $background=false) {
	    list($original_width, $original_height, $original_type) = getimagesize($filepath);
	    if ($original_width > $original_height) {
	        $new_width = $thumbnail_width;
	        $new_height = intval($original_height * $new_width / $original_width);
	    } else {
	        $new_height = $thumbnail_height;
	        $new_width = intval($original_width * $new_height / $original_height);
	    }
	    $dest_x = intval(($thumbnail_width - $new_width) / 2);
	    $dest_y = intval(($thumbnail_height - $new_height) / 2);
	    if ($original_type === 1) {
	        $imgt = "ImageGIF";
	        $imgcreatefrom = "ImageCreateFromGIF";
	    } else if ($original_type === 2) {
	        $imgt = "ImageJPEG";
	        $imgcreatefrom = "ImageCreateFromJPEG";
	    } else if ($original_type === 3) {
	        $imgt = "ImagePNG";
	        $imgcreatefrom = "ImageCreateFromPNG";
	    } else {
	        return false;
	    }
	    $old_image = $imgcreatefrom($filepath);
	    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height); // creates new image, but with a black background
	    // figuring out the color for the background
	    if(is_array($background) && count($background) === 3) {
	      list($red, $green, $blue) = $background;
	      $color = imagecolorallocate($new_image, $red, $green, $blue);
	      imagefill($new_image, 0, 0, $color);
	    // apply transparent background only if is a png image
	    } else if($background === 'transparent' && $original_type === 3) {
	      imagesavealpha($new_image, TRUE);
	      $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
	      imagefill($new_image, 0, 0, $color);
	    }
	    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
	    $imgt($new_image, $thumbpath);
	    return file_exists($thumbpath);
	}

}
