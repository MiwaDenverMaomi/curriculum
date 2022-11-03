//問1
let numbers = [2, 5, 12, 13, 15, 18, 22];
//ここに答えを実装してください。↓↓↓
function isEven() {
  numbers.map((num => {
    if (num % 2 === 0) {
      console.log(num + 'は偶数です');
    }
  }));
}

isEven(numbers);

//問2
class Car {
  constructor(gas,number) {
    this.gas = gas;
    this.number = number;
  }

  getNumGas() {
    console.log(`ガソリンは${this.gas}です。ナンバーは${this.number}です`);
  }
}

let car = new Car('レギュラー', '12345');
car.getNumGas();
