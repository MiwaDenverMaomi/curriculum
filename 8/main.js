//各言語のデータ用意
let vocabsArr = [
  {
    val: 'jp',
    language: "日本",
    greetings:["こんにちは","ありがとう","さようなら"]
  },
  {
    val: 'en',
    language: "English",
    greetings:["Hello","Thank you","Good Bye"]
  }
];
//言語名を表示する関数
let displayLanguageName=lang=> {
  let result = '';
  result = `<span style="font-weight:bold; margin-right:20px;">${lang}</span>`;
  return result;
}
//あいさつの配列を表示する関数
let displayGreetings=greetingsObj=> {
  let result = '';
  Object.keys(greetingsObj).map(g => {
    result +=`<span style="margin-right:20px;">${greetingsObj[g]}</span>`
  });
  return result;
}
//ひとつの言語の言語名とあいさつの配列を表示する関数
let displayOneLanguage=object=> {
  let result = '';
  Object.keys(object).map(v => {
    console.log('displayVocabs');
    if (v === 'language') {
      console.log(object[v]);
      result += displayLanguageName(object[v]);
    }
    if (v === 'greetings') {
      result += displayGreetings(object[v])
    }
  });
  return result;
}
//すべての言語の言語名と挨拶のはいれつを表示する関数
let displayAllLanguages=objArr=> {
  let result = '';
  if (objArr.length > 1) {
    objArr.map(i => {
      result += displayOneLanguage(i);
      result += `<br/>`;
    });
  } else {
    result=displayOneLanguage(objArr);
  }
  return result;
}

//SelectタグのDOM取得
let select = document.querySelector('#select');

//イベント発火
select.addEventListener('change', (e) => {
  //選択された値を取得
  const selectedVal = e.target.value;
  //結果を表示するノード取得
  const result = document.querySelector('#result');

  //日本語を選択の場合
  if (selectedVal === "jp") {
    result.innerHTML = displayAllLanguages(vocabsArr[0]);
  //Englishを選択の場合
  } else if(selectedVal === "en") {
    result.innerHTML = displayAllLanguages(vocabsArr[1]);
  //すべて表示を選択の場合
  } else if(selectedVal === "all") {
    result.innerHTML = displayAllLanguages(vocabsArr);
  //その他（value=Nullの場合）
  }else {
    result.innerHTML = "";
  }
});
