export abstract class BooleanValueObject {
  private readonly value: boolean

  constructor(value: boolean) {
    this.value = value
  }

  getValue(): boolean {
    return this.value
  }
}
