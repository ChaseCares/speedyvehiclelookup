
// Regular expression
VIN_RX = '[(a-h|j-n|p|r-z|0-9)]{17}'
MAX_LENGTH_RX = '^.{1,255}$'

// JavaScript function to perform input validation
function submitForm() {
  // initializing variables
  let VIN = document.forms["vehicleForm"]["newVIN"].value.toLowerCase();
  let color = document.forms["vehicleForm"]["color"].value;
  let make = document.forms["vehicleForm"]["make"].value;
  let year = document.forms["vehicleForm"]["year"].value;
  let model = document.forms["vehicleForm"]["model"].value;

if (VIN !== ''){
  if (!VIN.match(VIN_RX)) {
    cssSwitcher("newVIN", true)
    return false;
  }else{
    cssSwitcher("newVIN", false)
  }
}

if (color !== ''){
  if (!color.match(MAX_LENGTH_RX)) {
    cssSwitcher("color", true)
    return false;
  }else{
    cssSwitcher("color", false)
  }
}

if (make !== ''){
  if (!make.match(MAX_LENGTH_RX)) {
    cssSwitcher("make", true)
    return false;
  }else{
    cssSwitcher("make", false)
  }
}

if (model !== ''){
  if (!model.match(MAX_LENGTH_RX)) {
    cssSwitcher("model", true)
    return false;
  }else{
    cssSwitcher("model", false)
  }
}

if (year !== ''){
  if (year <= 1900 || year >= 2025){
    cssSwitcher("year", true)
    return false;
  }else{
    cssSwitcher("year", false)
  }
}

  document.getElementById("vehicleForm").submit();
}

function cssSwitcher(ID, add=true){
  if (add){
      document.getElementById(ID).classList.add("error");
      document.getElementById(ID + "Error").style.display="block";
  }else{
        document.getElementById(ID).classList.remove("error");
      document.getElementById(ID + "Error").style.display="none";
  }
}
