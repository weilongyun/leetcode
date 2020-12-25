import React from 'react';
import { RendererProps } from '../factory';
export interface PaginationProps extends RendererProps {
    activePage: number;
    items: number;
    maxButtons: number;
    hasNext: boolean;
    mode: string;
    onPageChange: (page: number, perPage?: number) => void;
    showPageInput: boolean;
}
export interface PaginationState {
    pageNum: string;
}
export default class Pagination extends React.Component<PaginationProps, PaginationState> {
    static defaultProps: {
        activePage: number;
        items: number;
        maxButtons: number;
        mode: string;
        hasNext: boolean;
        showPageInput: boolean;
    };
    state: {
        pageNum: string;
    };
    componentWillReceiveProps(nextProps: PaginationProps): void;
    renderSimple(): JSX.Element;
    handlePageChange(e: React.ChangeEvent<any>): void;
    renderNormal(): JSX.Element;
    render(): JSX.Element;
}
export declare class PaginationRenderer extends Pagination {
}
