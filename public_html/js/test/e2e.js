const equals = (arr1, arr2) => {
    let result = 1;
    const message = [];
    if (arr1.length === 0) {
        result = 0;
        message.push('Did you run prepare() ?');
    } else if (arr1.length !== arr2.length) {
        result = 0;
        message.push('Arrays have different lengths');
    } else {
        for (let i = 0; i < arr1.length - 1; i++) {
            if (arr1[i] !== arr2[i]) {
                message.push(`Difference on ${i} position, ${arr1[i]} !== ${arr2[i]}`);
                result = 0;
            }
        }
    }

    return {result, message};
};

// reports test
let reportsStartingPoint = [];

const prepare = () => {
    reportsStartingPoint = $(".tdNumber").text().split('\n').map(val => val.trim());
};

const test = () => {
    const reportsCurrentState = $(".tdNumber").text().split('\n').map(val => val.trim());

    return equals(reportsStartingPoint, reportsCurrentState);
};