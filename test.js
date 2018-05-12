

const { Chromeless } = require("chromeless");
const fetch = require("node-fetch");
const proxyChain = require("proxy-chain");

async function run(email) {
  if(typeof email==="string") var pass = email.split("@")[0];
  const chromeless = new Chromeless();
  const screenshot = await chromeless
    .goto("https://press-london.com/account/register")
    .wait("#modaal-close")
    .click("#modaal-close")
    .type(pass, "#FirstName")
    .type(pass, "#LastName")
    .type(email, "#Email")
    .type(pass, "#CreatePassword")
    .click("input[value='Create']")
    .wait("template-customers account swym-no-touch swym-ready")
    .goto("https://press-london.com/")
  await chromeless.end();
}
//Tagen1942@armyspy.com <-fresh email you can test w/o localhost
run("Tagen1942@armyspy.com").catch(err=>console.log(err));

async function getFakeEmail(){
  let res =  await fetch("http://Path_To_PHP_file_on_Localhost")
  .then(res=>res.text())
  .then(res=>run(res).catch(err=>console.log(err)));
}

//getFakeEmail();

async function fetchJson() {
  const res = await fetch("https://nordvpn.com/api/server");
  const json = await res.json();
  //   console.log(json);
  const goodOnes = json
    .filter(proxy => proxy.price === 0 && proxy.features.socks === true && proxy.country==="Canada");
    //.map(proxy => proxy.ip_address);
console.log(goodOnes)
}

async function runProxy(){

  const chromeless = new Chromeless();

  const screenshot = await chromeless
    .goto("https://www.whatismyip.com/what-is-my-public-ip-address/")
    .goto("")
  console.log("donezo");

  await chromeless.end()
}

//runProxy().catch(err=>console.log(err));
//fetchJson();
