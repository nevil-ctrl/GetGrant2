declare module "cleave.js" {
  interface CleaveOptions {
    numericOnly?: boolean;
    blocks?: number[];
    delimiters?: string[];
    prefix?: string;
    noImmediatePrefix?: boolean;
    rawValueTrimPrefix?: boolean;
    [key: string]: any;
  }

  class Cleave {
    constructor(element: HTMLElement | HTMLInputElement | string, options: CleaveOptions);
    setRawValue(value: string): void;
    getRawValue(): string;
    destroy(): void;
    [key: string]: any;
  }

  export default Cleave;
}
