

<button class="chatbot-toggler" style="background:#FBC257;">
    <span class="material-symbols-rounded"><i class="fa fa-id-badge" aria-hidden="true"></i></span>
    <span class="material-symbols-outlined"><i class="fa fa-times" aria-hidden="true"></i></span>
</button>
<style>
        .card {
            display: flex;
            align-items: center; /* Aligns items vertically center */
            padding: 10px;
            margin: 10px 0; /* Space between cards */
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff; /* Card background color */
            position: relative; /* For absolute positioning of the button */
            text-align:center;
        }
      
        .close-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            font-size: 18px;
            color: black;
            border-radius: 50%; /* Makes the image circular */
            border: none;
            padding: 5px 8px;
        }
    </style>
<div class="chatbot">
    <header style="background:#FBC257;">
      <h2>Lost Card</h2>
      <span class="close-btn material-symbols-outlined"><i class="fa fa-times" aria-hidden="true"></i></span>
    </header>
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12">
                <div class="rounded p-4" id="adjust">
                
                    <input type="hidden" name="id" id="hiddenId"> <!-- Hidden input for ID -->
                        <div class="">
                            <center><span id="myalert2"></span></center>
                        </div>
                        <div id="myalert" style="display:none;">
                            <div class="">
                                <center><span id="alerttext"></span></center>
                            </div>
                        </div>
                        <div id="myalert3" style="display:none;">
                            <div class="">
                                <div class="alert alert-success" id="alerttext3"></div>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div id="search" class="form-floating mb-4">
                            <input type="text" class="form-control" id="searchBox" name="pname" placeholder="Search Name" autocomplete="off" onkeyup="searchPersonell(this.value)">
                            <label for="floatingPassword">Search Name</label>
                        </div>
                        <!-- Card to display selected personnel -->
                        <div class="card" id="detailsModal" style="display:none;background-color:#e9ecef;">
    <span class="close-btn" onclick="closeModal()">×</span>
    
    <table style="margin-left: 30px; padding: 0px; margin-bottom: 0px; border: none;" class='table table-border' id='myTable'>
        <tr style="vertical-align:middle;">
            <!-- First column: Photo -->
            <td style="border-bottom-width:0px;"><img id="modalPhoto" src="" width='50' height='50'></td>
            <!-- Second column: Name and Department (stacked) -->
            <td style="text-align:left;border-bottom-width:0px;">
                <div id="modalTitle" style="font-weight: bold;"></div> <!-- Bold Name -->
                <div id="modalDepartment" style="opacity: 0.6;"></div> <!-- Department with less opacity -->
               
            </td>
        </tr>
    </table>
</div>
<div id="cam" style="display:none;position:fixed;" class="file-uploader">
                                         
                                         <img id="captured" class="preview-1" src="assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg" style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 15%; left:200px;" title="Upload Photo.." />
                                         <center><b>Capture Verification: </b></center>
                                      </div>

                                      <input hidden id="capturedImage" name="capturedImage">
                                     
                                    </div>


                        
                        <!-- Live Search Results -->
                        <div id="searchResults"></div>
        
                        
                        <button name="send" id="submitButton" class="alert alert-primary py-3 w-100 mb-4"><b>Send</b></button>

                </div>
            </div>
        </div>
    </div>
    <div class="chat-input" hidden>
      <textarea placeholder="Enter a message..." spellcheck="false" hidden></textarea>
      <span id="send-btn" class="material-symbols-rounded" hidden>send</span>
    </div>
</div>
<script>
    function searchPersonell(query) {
        console.log("Keyup detected, query:", query); 
        if (query.length === 0) {
            document.getElementById("searchResults").innerHTML = "";
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("searchResults").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "search_personnel.php?q=" + query, true);
        xhr.send();
    }
</script>



<script>
function showDetails(id, fullName, department, photo) {
    document.getElementById('modalTitle').innerText = fullName;
    document.getElementById('modalDepartment').innerText = department;
    document.getElementById('modalPhoto').src = 'admin/uploads/' + photo;

    // Set the hidden input field value
    document.getElementById('hiddenId').value = id;

    // Show the modal
    document.getElementById('detailsModal').style.display = 'flex';
    document.getElementById('search').style.display = 'none';
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('cam').style.display = 'block';
    document.getElementById('adjust').style.height = '300px';
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
    document.getElementById('search').style.display = 'block';
    document.getElementById('searchResults').style.display = 'block';
    document.getElementById('searchResults').style.paddingTop = '50px';
    document.getElementById('cam').style.display = 'none';
    document.getElementById('adjust').style.height = '0px';
    document.getElementById('hiddenId').value = '';
}
</script>